<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->status == 1){
            return redirect()->route('user.dashboard')->with([
                'message' => 'Logged in successfully.',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->route('user.index')->with([
            'message' => 'Something went wrong !',
            'alert-type' => 'warning'
        ]);
    }

    public function username()
    {
        return 'username';
    }

}
