<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Client dashboard
    public function index()
    {
        $user = Auth::user();
        $feedbacks = Feedback::latest()->get();
        $bookings = Booking::where('userID', $user->id)->get();
        $loyalty = $user->loyaltyPoints;

        return view('client.dashboard', compact('user', 'feedbacks', 'bookings', 'loyalty'));
    }

    // View loyalty points
    public function viewLoyaltyPoints()
    {
        $user = Auth::user();
        return view('dashboard.client.loyalty', compact('user'));
    }

    // Admin: Edit loyalty points for a user
    public function editLoyaltyPoints(Request $request, $userID)
    {
        $request->validate(['loyaltyPoints' => 'required|integer|min:0']);

        $user = User::where('userID', $userID)->firstOrFail(); // adjust if using ID instead
        $user->loyaltyPoints = $request->loyaltyPoints;
        $user->save();

        return redirect()->back()->with('success', 'Loyalty points updated.');
    }
}
