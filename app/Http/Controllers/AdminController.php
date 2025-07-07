<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Models\PastBooking;
use App\Models\Service;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class AdminController extends Controller
{
    // public function dashboard()
    // {
    //     return view('admin.dashboard');
    // }

   public function services(Request $request)
{
    $query = Service::query();

    if ($request->has('name') && $request->name != '') {
        $query->where('name', $request->name);
    }

    $services = $query->get();
    $serviceNames = Service::select('name')->distinct()->pluck('name');

    return view('admin.services.index', compact('services', 'serviceNames'));
}








public function showDashboard()
{
    $pastBookingsRaw = DB::table('past_bookings')
        ->whereNotNull('selectedDate')
        ->whereNotNull('selectedTime')
        ->get();

    $bookings = collect($pastBookingsRaw)->map(function ($b) {
        $b = (array) $b;

        $date = trim($b['selectedDate']);
        $rawTime = trim($b['selectedTime']);

        try {
            $time = Carbon::parse($rawTime)->format('H:i:s'); // ✅ Extract only time (HH:mm:ss)
        } catch (\Exception $e) {
            \Log::error('Invalid selectedTime format: ' . $rawTime);
            $time = '00:00:00';
        }

        return [
            'title' => $b['service'] . ' - ' . $b['name'],
            'start' => $date . 'T' . $time,
            'color' => match ($b['status']) {
                'completed' => '#a7f3d0',
                'cancelled' => '#fecaca',
                default => '#fbcfe8',
            },
            'extendedProps' => [
                'status' => $b['status'],
                'location' => $b['address'] ?? '-',
                'user' => $b['name'],
                'service' => $b['service'],
                'price' => $b['price'] ?? 0,
                'notes' => $b['notes'] ?? '-',
            ],
        ];
    });

    return view('admin.dashboard', compact('bookings'));
}




public function createBooking()

{$maxPerDay = 3;

$datesFromBookings = DB::table('bookings')
    ->select('selectedDate as date')
    ->groupBy('selectedDate')
    ->havingRaw('COUNT(*) >= ?', [$maxPerDay]);

$datesFromPast = DB::table('past_bookings')
    ->select('selectedDate as date')
    ->whereIn('status', ['upcoming', 'completed'])
    ->groupBy('selectedDate')
    ->havingRaw('COUNT(*) >= ?', [$maxPerDay]);

// Create subquery union of both
$unionQuery = $datesFromBookings->union($datesFromPast);

$fullyBookedDates = DB::table(DB::raw("({$unionQuery->toSql()}) as fully_booked"))
    ->mergeBindings($unionQuery) // required to bind the ? values like $maxPerDay
    ->pluck('date')
    ->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
    ->toArray();





    $users = User::all();
    $services = Service::all();

    return view('admin.bookings.create', compact('users', 'services', 'fullyBookedDates'));
}




public function analytics()
{
    // Monthly Income (sum of full_payment by month)
    $monthlyRawIncome = DB::table('past_bookings')
    ->selectRaw('DATE_FORMAT(selectedDate, "%b") as month, SUM(full_payment) as total')
    ->groupBy('month')
    ->orderByRaw('STR_TO_DATE(month, "%b")')
    ->get();

    $currentMonthIncome = DB::table('past_bookings')
    ->whereMonth('selectedDate', now()->month)
    ->whereYear('selectedDate', now()->year)
    ->sum('full_payment');


$months = collect(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);

$incomeByMonth = $months->map(function ($month) use ($monthlyRawIncome) {
    $match = $monthlyRawIncome->firstWhere('month', $month);
   return $match ? (float) $match->total : 0;

});

$monthlyIncome = $incomeByMonth->sum();



    // Clients
    $clientCount = DB::table('users')->count();

    // Booking Trends: Stacked bar (bookings by service per month)
    $rawBookingData = DB::table('past_bookings')
    ->selectRaw('DATE_FORMAT(selectedDate, "%b") as month, service, COUNT(*) as total')
    ->groupBy('month', 'service')
    ->orderByRaw('STR_TO_DATE(month, "%b")')
    ->get()
    ->map(fn ($item) => (object) $item);  // <-- key fix


    $months = collect(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);
    $services = $rawBookingData->pluck('service')->unique();

    // Fix bookingDatasets: convert to indexed array
$bookingDatasets = $services->map(function ($service) use ($months, $rawBookingData) {
    return [
        'label' => $service,
        'data' => $months->map(function ($month) use ($rawBookingData, $service) {
            $dataPoint = $rawBookingData->firstWhere(fn ($item) => $item->month === $month && $item->service === $service);
            return $dataPoint ? $dataPoint->total : 0;
        }),
        'backgroundColor' => '#' . substr(md5($service), 0, 6),
    ];
})->values(); // 👈 convert to array!




    // Cancelled bookings by service - Line chart
  $totalBookings = DB::table('past_bookings')->count();
$totalCancellations = DB::table('past_bookings')->where('status', 'cancelled')->count();

$cancelReasons = DB::table('past_bookings')
    ->where('status', 'cancelled')
    ->whereNotNull('cancel_reason') // 👈 filter out nulls
    ->select('cancel_reason', DB::raw('COUNT(*) as total'))
    ->groupBy('cancel_reason')
    ->orderByDesc('total')
    ->get();



    


    // Popular Services (Top 3)
    $popularServices = DB::table('past_bookings')
    ->select('service', DB::raw('COUNT(*) as total'))
    ->groupBy('service')
    ->orderByDesc('total')
    ->get(); // 👈 Removed ->limit(3)

    //Client and Feedback
    $feedback = DB::table('feedback')->latest()->get(); // Adjust table name if needed


    return view('admin.analytics', compact(
    'clientCount',
    'monthlyIncome',
    'popularServices',
    'months',
    'bookingDatasets',
    'cancelReasons',
    'totalBookings',
    'incomeByMonth',
    'feedback',
    'totalCancellations',
    'currentMonthIncome' // 👈 ADD THIS
));}


public function generateReport(Request $request)
{
    $selectedYear = $request->query('year'); // e.g., 2024

    $monthlyRawIncome = DB::table('past_bookings')
        ->when($selectedYear, fn($q) => $q->whereYear('selectedDate', $selectedYear))
        ->selectRaw('DATE_FORMAT(selectedDate, "%b") as month, SUM(full_payment) as total')
        ->groupBy('month')
        ->orderByRaw('STR_TO_DATE(month, "%b")')
        ->get();
    
        

    $months = collect(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);
    $incomeByMonth = $months->map(function ($month) use ($monthlyRawIncome) {
        $match = $monthlyRawIncome->firstWhere('month', $month);
        return $match ? (float) $match->total : 0;
    });

    $clientCount = DB::table('users')->count();
    $monthlyIncome = $incomeByMonth->sum();

    // Filter data for this year
    $filtered = DB::table('past_bookings');
    if ($selectedYear) {
        $filtered = $filtered->whereYear('selectedDate', $selectedYear);
    }

    $popularServices = (clone $filtered)
        ->select('service', DB::raw('COUNT(*) as total'))
        ->groupBy('service')
        ->orderByDesc('total')
        ->get();

    $cancelReasons = (clone $filtered)
        ->where('status', 'cancelled')
        ->whereNotNull('cancel_reason')
        ->select('cancel_reason', DB::raw('COUNT(*) as total'))
        ->groupBy('cancel_reason')
        ->get();

    $pdf = Pdf::loadView('admin.analytics_report_pdf', compact(
        'selectedYear',
        'months',
        'incomeByMonth',
        'clientCount',
        'monthlyIncome',
        'popularServices',
        'cancelReasons'
    ));

    return $pdf->download("analytics_report_" . ($selectedYear ?? 'all') . ".pdf");
}


public function viewAllBookings()
{
    $upcomingBookings = PastBooking::where('status', 'upcoming')
        ->orderBy('selectedDate')
        ->orderBy('selectedTime')
        ->get();

    return view('admin.my_bookings', [
        'upcomingBookings' => PastBooking::where('status', 'upcoming')->orderBy('selectedDate')->get(),
        'completedBookings' => PastBooking::where('status', 'completed')->orderByDesc('selectedDate')->get(),
        'cancelledBookings' => PastBooking::where('status', 'cancelled')->orderByDesc('selectedDate')->get(),
    ]);
}

public function markCompleted($id)
{
    $booking = PastBooking::findOrFail($id);

    // Only mark if not already completed
    if ($booking->status !== 'completed') {
        $booking->status = 'completed';
        $booking->save();

        // 🧠 Calculate points from payment (after RM250 deposit)
        $pointsBase = max(($booking->full_payment ?? 0) - 250, 0);
        $pointsEarned = floor($pointsBase / 10); // RM10 = 1 point

        // ✅ Update user points
        if ($booking->user_id) {
            $user = User::find($booking->user_id);
            if ($user) {
                $user->loyaltyPoints += $pointsEarned;
                $user->save();
            }
        }
    }

    return back()->with('success', 'Booking marked as completed and points awarded.');
}



//Client Page
public function showClients(Request $request)
{
    $search = $request->input('search');

    $clients = User::role('client') // ✅ Correct for Spatie roles
        ->when($search, function ($query) use ($search) {
            $query->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        })
        ->paginate(10);

    return view('admin.client', compact('clients', 'search'));
}


public function updatePoints(Request $request, $id)
{
    $request->validate([
        'pointsToAdd' => 'required|integer|min:1',
    ]);

    $user = User::findOrFail($id);
    $user->loyaltyPoints += $request->pointsToAdd;
    $user->save();

    return back()->with('success', 'Points added successfully.');
}

}
