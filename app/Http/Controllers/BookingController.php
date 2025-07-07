<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\PastBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class BookingController extends Controller
{
 public function add(Request $request)
{
    // If it's a simple service
    if ($request->has(['service', 'price', 'quantity'])) {
        Booking::create([
            'user_id' => Auth::id(),
            'service' => $request->input('service'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'is_reward' => session('rewardRedeem', false), // ✅ include this
        ]);

        return back()->with('success', 'Makeover Package Added!');
    }

    // If it's selections from henna or grouped services
    $selections = $request->input('selections', []);
    $prices = $request->input('prices', []);
    $service = $request->input('service') ?? 'Henna Design';

    foreach ($selections as $design => $qty) {
        if ($qty > 0) {
            Booking::create([
                'user_id' => Auth::id(),
                'service' => "$service – $design",
                'price' => $prices[$design],
                'quantity' => $qty,
                'is_reward' => session('rewardRedeem', false), // ✅ include this
            ]);
        }
    }

    return back()->with('success', 'Henna designs added to booking!');
}



public function view()
{
    $user = Auth::user();

    // Clear session if rewardRedeem set but no reward booking exists
    if (! Booking::where('user_id', $user->id)->where('is_reward', true)->exists()) {
        session()->forget('rewardRedeem');
    }

    $bookings = Booking::where('user_id', $user->id)->get();
    return view('booking', compact('bookings'));
}



    public function viewBookings()
{
    $bookings = session('bookings', []);
    return view('booking', compact('bookings'));
}


public function uploadPhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|max:2048',
        'booking_id' => 'required|exists:bookings,id',
    ]);

    $path = $request->file('photo')->store('uploads', 'public');

    Booking::where('id', $request->booking_id)
           ->where('user_id', Auth::id())
           ->update(['photo_path' => 'storage/' . $path]);

    return back()->with('success', 'Photo uploaded successfully!');
}




public function store(Request $request)
{
    $request->validate([
        'service' => 'required',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
    ]);

    Booking::create([
        'user_id' => Auth::id(),
        'service' => $request->service,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'is_reward' => session('rewardRedeem', false), // ✅ include this
    ]);

    return back()->with('success', 'Booking created successfully!');
}


public function index()
{
    $bookings = Booking::where('user_id', Auth::id())->get();

    return view('your_bookings', compact('bookings'));
}

public function remove($id)
{
    $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $booking->delete();
    return back()->with('success', 'Booking removed.');
}

public function clear()
{
    Booking::where('user_id', Auth::id())->delete();
    return back()->with('success', 'All bookings cleared.');
}

public function updateQuantity(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    if ($request->action === 'increase') {
        $booking->quantity += 1;
    } elseif ($request->action === 'decrease' && $booking->quantity > 1) {
        $booking->quantity -= 1;
    }
    $booking->save();

    return back()->with('success', 'Quantity updated successfully.');
}


public function updateComment(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    $booking->comment = $request->comment;
    $booking->save();

    return back();
}

public function showBookingForm()
{
    session()->forget([
        'booking_address',
        'booking_postcode',
        'booking_city',
        'booking_state',
        'booking_selectedDate',
        'booking_selectedTime',
        'booking_notes',
    ]);

    return view('booking.form');
}

public function storeAddress(Request $request)
{
    $validated = $request->validate([
        'address' => 'required|string|max:255',
        'notes' => 'nullable|string|max:500',
    ]);

    // Store in session for now
    session([
        'address' => $validated['address'],
        'notes' => $validated['notes'],
    ]);

    return redirect()->route('payment.page'); // or your next step
}

public function confirm(Request $request)

{
    $validated = $request->validate([
        'name' => 'required|string',
        'address' => 'required|string',
        'phoneNumber' => 'required|string',
        'postcode' => 'required|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'selectedDate' => 'required|date',
        'selectedTime' => 'required',
        'notes' => 'nullable|string',
    ]);

    $user = Auth::user();
    $state = $validated['state'];
    $isReward = session('rewardRedeem', false);

    $transportationFees = [
        'Selangor' => 50.00, 'Kuala Lumpur' => 65.00, 'Johor' => 80.00,
        'Penang' => 90.00, 'Perak' => 80.00, 'Negeri Sembilan' => 70.00,
        'Melaka' => 75.00, 'Pahang' => 80.00, 'Kelantan' => 85.00,
        'Terengganu' => 85.00, 'Kedah' => 150.00, 'Perlis' => 180.00,
        'Sabah' => 200.00, 'Sarawak' => 200.00,
    ];
    $transportation = $transportationFees[$state] ?? 0;

    // ✅ If reward booking, replace cart with free booking
    if ($isReward) {
        Booking::where('user_id', $user->id)->delete(); // Optional clean-up

        Booking::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'service' => 'Free Full Personal Makeover (Reward)',
            'price' => 0.00,
            'quantity' => 1,
            'selectedDate' => $validated['selectedDate'],
            'selectedTime' => $validated['selectedTime'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postcode' => $validated['postcode'],
            'deposit' => 250.00,
            'full_payment' => 0.00,
            'notes' => $validated['notes'],
            'is_reward' => true,
        ]);
    }

    // Store to session
    session([
        'booking_name' => $validated['name'],
        'booking_address' => $validated['address'],
        'booking_phoneNumber' => $validated['phoneNumber'],
        'booking_postcode' => $validated['postcode'],
        'booking_city' => $validated['city'],
        'booking_state' => $validated['state'],
        'booking_date' => $validated['selectedDate'],
        'booking_time' => $validated['selectedTime'],
        'booking_notes' => $validated['notes'],
        'transportation_fee' => $isReward ? 0 : $transportation,
    ]);

    return redirect()->route('summary');
    
}





public function summary()
{
    $bookings = Booking::where('user_id', Auth::id())->get();

    $total = $bookings->sum(fn($b) => $b->price * $b->quantity);
    $transportation = session('transportation_fee', 0);
    $grandTotal = $total + $transportation;

    return view('summary', compact('bookings', 'total', 'transportation', 'grandTotal')); 
}



public function sendStripeReceipt($paymentDetails)
{
    $data = [
        'name' => $paymentDetails['customer_name'],
        'email' => $paymentDetails['email'],
        'phone' => $paymentDetails['phone'],
        'amount' => $paymentDetails['amount'] / 100,
        'refNo' => $paymentDetails['payment_intent_id'],
        'method' => 'Card',
        'date' => now()->format('d/m/Y H:i:s'),
        'billUrl' => $paymentDetails['receipt_url'],
    ];

    $pdf = Pdf::loadView('emails.receipt', $data);

    // Send to customer
    Mail::send('emails.receipt', $data, function ($message) use ($data, $pdf) {
        $message->to($data['email'], $data['name'])
                ->subject('Your Payment Receipt')
                ->attachData($pdf->output(), 'receipt.pdf');
    });

    // Send to admin/owner
    Mail::send('emails.receipt', $data, function ($message) use ($data, $pdf) {
        $message->to('periyaa@graduate.utm.my', 'YOURSITA')
                ->subject('Customer Payment Receipt')
                ->attachData($pdf->output(), 'receipt.pdf');
    });
}

public function showBookingHistory()
{
    $userId = Auth::id();

    // ✅ Auto-mark completed bookings
    PastBooking::where('user_id', $userId)
        ->where('status', 'upcoming')
        ->whereDate('selectedDate', '<', now())
        ->update(['status' => 'completed']);

    // ✅ Get upcoming and completed bookings
    $upcomingBookings = PastBooking::where('user_id', $userId)
    ->where('status', 'upcoming')
    ->get()
    ->groupBy(function ($booking) {
        return $booking->selectedDate . '|' . $booking->selectedTime . '|' . $booking->address;
    });


    $completedBookings = PastBooking::where('user_id', $userId)
        ->where('status', 'completed')
        ->get();

    return view('my_bookings', compact('upcomingBookings', 'completedBookings'));
}

public function cancelGroup(Request $request)
{
    $ids = $request->input('booking_ids', []);
    $reason = $request->input('cancel_reason');

    PastBooking::whereIn('id', $ids)
        ->where('status', 'upcoming')
        ->update([
            'status' => 'cancelled',
            'cancel_reason' => $reason,
        ]);

    return back()->with('success', 'Booking cancelled successfully.');
}



//Blocked Slots
public function getBlockedSlots()
{
    try {
        $bookings = Booking::select('selectedDate')
            ->whereNotNull('selectedDate');

        $pastBookings = DB::table('past_bookings')
            ->select('selectedDate')
            ->whereNotNull('selectedDate')
            ->whereIn('status', ['upcoming', 'completed']); // ✅ Exclude cancelled

        // Merge both queries as union
        $allDates = $bookings->union($pastBookings)->get();

        $blocked = $allDates->pluck('selectedDate')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->unique()
            ->values();

        return response()->json($blocked);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
}


public function completePayment($bookingId)
{
    $booking = Booking::findOrFail($bookingId);

    $total = $booking->price * $booking->quantity;
    $deposit = $total * 0.5;

    // Copy booking to past_bookings
    PastBooking::create([
        'user_id' => $booking->user_id,
        'name' => $booking->name,
        'service' => $booking->service,
        'price' => $booking->price,
        'quantity' => $booking->quantity,
        'selectedDate' => $booking->selectedDate,
        'selectedTime' => $booking->selectedTime,
        'address' => $booking->address,
        'city' => $booking->city,
        'state' => $booking->state,
        'postcode' => $booking->postcode,
        'deposit' => $deposit,
        'full_payment' => $total,
        // add other columns like transaction_id if needed
    ]);

    $booking->delete();

    return redirect()->route('your.route.name')->with('success', 'Payment completed and moved to history.');
}

public function redeemReward()
{
    $user = Auth::user();

    if ($user->loyaltyPoints >= 1000) {
        session(['rewardRedeem' => true]);

        // ✅ Remove existing reward booking to prevent duplicates
        Booking::where('user_id', $user->id)
            ->where('is_reward', true)
            ->delete();

        // ✅ Add the reward booking directly
        Booking::create([
            'user_id' => $user->id,
            'service' => 'Free Full Personal Makeover (Reward)',
            'price' => 0.00,
            'quantity' => 1,
            'is_reward' => true,
            'status' => 'upcoming', // or whatever default status you use
        ]);

        return redirect()->route('booking.view')->with('success', 'You are redeeming your free full personal makeover!');
    }

    return back()->with('error', 'Insufficient loyalty points.');
}






}
