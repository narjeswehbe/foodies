<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feedbacks;
use App\Models\Offer;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {

        $specials = Category::where('name', 'specials')->first();
        $offers = Offer::all();
        $feedbacks = Feedbacks::all();



        return view('welcome', compact('specials' , 'feedbacks','offers'));
    }
    public function thankyou()
    {
        return view('thankyou');
    }

    public function feedbacks()
    {
        return view('feedbacks.feedbacks-ok');
    }
}
