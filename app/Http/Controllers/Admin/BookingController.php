<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create()
    {
        $users = User::all();
        $services = Service::all();

        return view('admin.bookings.create', compact('users', 'services'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'customer_email' => 'nullable|email',
        'customer_phone' => 'nullable|string',
        'service' => 'required|string',
        'date' => 'required|date',
        'time' => 'required',
        'status' => 'required|string',
        'notes' => 'nullable|string',
        'pax' => 'nullable|integer|min:1',
        'price' => 'nullable|numeric', // allow price to be nullable for fallback
        'location' => 'required|string',
    ]);

    // Fallback logic if price is missing or 0
    if (empty($validated['price']) || $validated['price'] == 0) {
        $service = Service::where('name', $validated['service'])->first();
        $basePrice = $service?->price ?? 0;
        $quantity = $validated['pax'] ?? 1;

        $travelFee = 0;
        $location = strtolower($validated['location']);

        if (str_contains($location, 'pahang')) $travelFee = 80;
        elseif (str_contains($location, 'selangor')) $travelFee = 50;
        elseif (str_contains($location, 'johor')) $travelFee = 80;
        elseif (str_contains($location, 'kuala lumpur')) $travelFee = 65;
        elseif (str_contains($location, 'perak')) $travelFee = 80;
        elseif (str_contains($location, 'penang')) $travelFee = 90;
        elseif (str_contains($location, 'negeri sembilan')) $travelFee = 70;
        elseif (str_contains($location, 'melaka')) $travelFee = 75;
        elseif (str_contains($location, 'kelantan')) $travelFee = 85;
        elseif (str_contains($location, 'terengganu')) $travelFee = 85;
        elseif (str_contains($location, 'kedah')) $travelFee = 150;
        elseif (str_contains($location, 'perlis')) $travelFee = 180;
        elseif (str_contains($location, 'sabah')) $travelFee = 200;
        elseif (str_contains($location, 'sarawak')) $travelFee = 200;

        $validated['price'] = ($basePrice * $quantity) + $travelFee;
    }

    // ✅ Directly insert into past_bookings
    DB::table('past_bookings')->insert([
        'user_id' => null,
        'name' => $validated['name'],
        'phoneNumber' => $validated['customer_phone'] ?? null,
        'service' => $validated['service'],
        'quantity' => $validated['pax'] ?? 1,
        'selectedDate' => $validated['date'],
        'selectedTime' => $validated['time'],
        'status' => $validated['status'],
        'price' => $validated['price'],
        'full_payment' => $validated['price'],
        'notes' => $validated['notes'] ?? null,
        'address' => $validated['location'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully.');
}



}
