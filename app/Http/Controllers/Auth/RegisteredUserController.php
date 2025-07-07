<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): View
    {
        return view('auth.register'); // make sure your view path is correct
    }

    /**
     * Handle registration form submission.
     */
    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'phoneNumber' => 'required|string|max:20',
        'dateOfBirth' => 'required|date',
    ]);

    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'phoneNumber' => $request->phoneNumber,
        'dateOfBirth' => $request->dateOfBirth,
    ]);

    // ✅ Assign the 'client' role to new users
    $user->assignRole('client');

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
}

}
