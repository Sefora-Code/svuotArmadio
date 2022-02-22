<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * add logic to proxy users to the right page after login
     * @return string
     */
    public function redirectTo()
    {
        $for = [
            'super-admin' => RouteServiceProvider::HOME,
            'admin' => RouteServiceProvider::HOME,
            'deliverer'  => RouteServiceProvider::FRONT_HOME,
            'customer'  => RouteServiceProvider::FRONT_HOME
        ];
        return $this->redirectTo = $for[auth()->user()->getRoleNames()->first()];
    }
    
}
