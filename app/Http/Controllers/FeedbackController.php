<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    /**
     * Store feedback in the database.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        
        Feedback::create($validated);
        
        return redirect()->to(url()->previous() . '#feedback')->with('success', 'Thank you for your feedback!');

    }

    /**
     * (Optional) Show all feedbacks - for slider/carousel use.
     */
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('dashboard', compact('feedbacks')); // Replace 'your-view-file' with your actual blade file
    }
}
