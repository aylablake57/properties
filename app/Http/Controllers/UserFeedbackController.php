<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFeedbackRequest;
use App\Models\UserFeedback;
use Illuminate\Http\Request;

class UserFeedbackController extends Controller
{
    public function submitFeedback()
    {
        return view('feedback.form');
    }

    public function store(UserFeedbackRequest $request)
    {
        $data = UserFeedback::create([
            'user_id' => $request->user_id,
            'comments' => $request->comments,
            'suggestions' => $request->suggestions,
            'rating' => $request->rating,
            'status' => 'Draft',
        ]);

        if (!$data) {
            return redirect()->back()->with(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
        }

        return redirect()->back()->with(['success' => true, 'message' => 'Feedback submitted successfully.']);
    }

}
