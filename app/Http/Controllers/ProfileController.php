<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    try {
        $user = Auth::user();

        $user->username = $request->username; // ✅ Fix this
        $user->email = $request->email;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->phoneNumber = $request->phoneNumber;
        $user->dateOfBirth = $request->dateOfBirth;
        $user->save();

        return back()->with('status', 'profile-updated');

    } catch (\Exception $e) {
        \Log::error('Profile update failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Something went wrong.']);
    }
}

    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
       
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
