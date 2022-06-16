<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Employee;

class HomeController extends Controller
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
        $for = [
            'super-admin' => 'home',
            'admin' => 'home',
            'deliverer'  => 'front.home',
            'customer'  => 'front.home'
        ];
        return view($for[auth()->user()->getRoleNames()->first()]);
    }

    /**
     * Show the page to be used whtn picking up the phone
     *
     * @return Renderable
     */
    public function phone(): Renderable
    {
        $employees = Employee::get();
        return view("orders.pick_up_phone", compact('employees'));
    }
}
