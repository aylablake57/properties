<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'reviewRating' => 'required|integer|between:1,5',
            'message' => 'required|string|max:1500',
        ]);

        // Create a new review record in the database
        Review::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your review has been submitted successfully!');
    }
}

