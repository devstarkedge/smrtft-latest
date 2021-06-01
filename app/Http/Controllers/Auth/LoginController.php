<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'password' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        $email=$request->email;
        $password=$request->password;
        if (Auth::attempt(['email'=>$email,'password'=>$password])) {
          
            if (Auth::user()->roles()->first()->name == 'User') {
                return redirect()->route('user.dashboard');
            } elseif (Auth::user()->roles()->first()->name == 'Partner') {
                return redirect()->route('partner.dashboard');
            }elseif (Auth::user()->roles()->first()->name == 'Administrator'){
                return redirect()->route('admin.dashboard');
            }elseif (Auth::user()->roles()->first()->name == 'SubAdmin'){
                return redirect()->route('admin.dashboard');
            } else {
                
            }
        }
        return redirect()->back()->withInput()->withErrors(['invalid credentials.']);
    }

}
