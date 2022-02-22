<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;

class FrontPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('front.home');
    }
    
    public function bookingsHome()
    {
        return view('front.bookings.home');
    }
    
    public function pickupsHome() 
    {
        return view('front.pickups.home');
    }
}
