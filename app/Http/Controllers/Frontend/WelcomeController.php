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
        $f1 = Feedbacks::find(1);
        $f2 = Feedbacks::find(2);
        $f3 = Feedbacks::find(3);



        return view('welcome', compact('specials' , 'f1','f2','f3' ,'offers'));
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
