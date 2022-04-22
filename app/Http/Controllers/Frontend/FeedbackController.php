<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackStoreRequest;
use App\Models\Feedbacks;
use App\Models\Offer;

class FeedbackController extends Controller
{
    public function store(FeedbackStoreRequest $request)
    {
        Feedbacks::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'feedback' => $request->feedback,
            'rating' => $request->rating,
        ]);

        return to_route('feedbacks')->with('success' , 'Thank you for your feedback');
    }

    public function show()
    {
        $offers=Offer::all();
        return view('feedbacks.feedbacks-all' , compact('offers'));
    }

}
