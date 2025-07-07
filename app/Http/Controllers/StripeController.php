<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use App\Models\PastBooking;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class StripeController extends Controller
{
    public function showForm()
    {
        return view('payment');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'myr',
                    'unit_amount' => $request->amount * 100,
                    'product_data' => [
                        'name' => 'YOURSITA Booking Payment',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $request->email,
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url);
    }

   public function success(Request $request)
{

    Stripe::setApiKey(config('services.stripe.secret'));

    $sessionId = $request->get('session_id');
    $session = Session::retrieve($sessionId);
    $paymentIntent = PaymentIntent::retrieve($session->payment_intent);

    $user = Auth::user();
    $userId = $user->id;

    $bookings = Booking::where('user_id', $userId)->get();
    \Log::debug('📦 Bookings Found: ' . $bookings->count());

    $isReward = $bookings->first()?->is_reward ?? false;

    // Update bookings with session data
    $savedBookings = [];
    foreach ($bookings as $booking) {
        $booking->name = session('booking_name');
        $booking->phoneNumber = session('booking_phoneNumber');
        $booking->address = session('booking_address');
        $booking->postcode = session('booking_postcode');
        $booking->city = session('booking_city');
        $booking->state = session('booking_state');
        $booking->selectedDate = session('booking_date');
        $booking->selectedTime = session('booking_time');
        $booking->notes = session('booking_notes');
        $booking->save();
        $savedBookings[] = $booking;
    }

    if ($isReward && $user->loyaltyPoints >= 1000) {
        $user->loyaltyPoints -= 1000;
        $user->save();
        session()->forget('rewardRedeem');
        \Log::info('🎯 1000 points deducted for reward booking.');
    }

    $grouped = collect($savedBookings)
        ->groupBy(fn($item) => $item->service . '-' . $item->price)
        ->map(function ($group) {
            $first = $group->first();
            return [
                'service' => $first->service,
                'price' => $first->price,
                'quantity' => $group->sum('quantity'),
                'user_id' => $first->user_id,
                'name' => $first->name,
                'phoneNumber' => $first->phoneNumber,
                'address' => $first->address,
                'postcode' => $first->postcode,
                'city' => $first->city,
                'state' => $first->state,
                'selectedDate' => $first->selectedDate,
                'selectedTime' => $first->selectedTime,
                'notes' => $first->notes,
            ];
        });

    $transport = session('transportation_fee') ?? 0;
    $deposit = 250;
    $firstService = true;

    $totalPoints = 0;

    foreach ($grouped as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total = $subtotal;

        if ($firstService) {
            $total += $transport;
            $firstService = false;
        }

        $total += $deposit;

        // ✅ Points: only earn points if NOT reward booking
        if (!$isReward) {
            $points = floor(($total - $deposit) / 10); // exclude deposit
            $totalPoints += $points;
        }

        PastBooking::create([
            ...$item,
            'transaction_id' => $paymentIntent->id,
            'status' => 'upcoming',
            'deposit' => $deposit,
            'full_payment' => $total,
        ]);
    }

    // ✅ Add earned points after payment
    if (!$isReward && $totalPoints > 0) {
        $user->loyaltyPoints += $totalPoints;
        $user->save();
        \Log::info("💎 $totalPoints points awarded to user.");
    }

    Booking::where('user_id', $userId)->delete();

    $first = $savedBookings[0] ?? null;
    if ($first) {
        $this->sendStripeReceipt([
            'customer_name' => $first->name,
            'email' => $session->customer_email,
            'phone' => $first->phoneNumber ?? '-',
            'amount' => $session->amount_total,
            'payment_intent_id' => $paymentIntent->id,
            'receipt_url' => $paymentIntent->charges->data[0]->receipt_url ?? '#',
        ]);
    }

    session()->forget([
        'booking_name', 'booking_address', 'booking_phoneNumber',
        'booking_postcode', 'booking_city', 'booking_state',
        'booking_date', 'booking_time', 'booking_notes', 'transportation_fee',
    ]);

    return view('confirm', [
        'amount' => $session->amount_total,
        'transactionId' => $paymentIntent->id,
        'date' => now()->toDateTimeString(),
    ]);
}



    private function sendStripeReceipt($data)
    {
        $pdfCustomer = Pdf::loadView('receipt_customer', $data);
        $pdfOwner = Pdf::loadView('receipt_owner', $data);

        Mail::send('receipt_customer', $data, function ($message) use ($data, $pdfCustomer) {
            $message->to($data['email'], $data['customer_name'])
                ->subject('YourSITA Payment Receipt')
                ->attachData($pdfCustomer->output(), 'Customer_Receipt.pdf');
        });

        Mail::send('receipt_owner', $data, function ($message) use ($data, $pdfOwner) {
            $message->to('periyaa@graduate.utm.my', 'YOURSITA')
                ->subject('New Customer Payment Received')
                ->attachData($pdfOwner->output(), 'Owner_Receipt.pdf');
        });
    }

    public function cancel()
    {
        return '❌ Payment canceled.';
    }
}
