<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Auth\LoginController;

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
}
