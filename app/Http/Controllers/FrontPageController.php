<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Employee;

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
        $thisUser = Auth::user();
        if ($thisUser->customer)
        {
            return view('front.home', compact('thisUser'));
        }
        else
        {
            $thisEmployeeId = Employee::where('user_id', Auth::user()->id)->pluck('id')->first();
            $orders = Order::where('employee_id', $thisEmployeeId)->with('orderDetails')->orderByDesc('id')->get();
            
            return view('pickups.home', compact('thisUser', 'orders'));
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ordersHome()
    {
        $thisUser = Auth::user();
        return view('front.orders.home', compact('thisUser'));
    }
    
    public function pickupsHome() 
    {
        $thisCustomerId = Customer::where('user_id', Auth::user()->id)->pluck('id')->first();
        $orders = Order::where('customer_id', $thisCustomerId)->with('orderDetails')->orderByDesc('id')->get();
        return view('front.pickups.home', compact('orders'));
    }
    
    public function pickupsMapEmp()
    {
        $thisEmployeeId = Employee::where('user_id', Auth::user()->id)->pluck('id')->first();
        $orders = Order::where('employee_id', $thisEmployeeId)->with('orderDetails')->orderByDesc('id')->get();
        return view('pickups.map', compact('orders'));
    }
}
