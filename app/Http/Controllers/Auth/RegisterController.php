<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Model\Role;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    public function index(Request $request) {
        return view('auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function store(Request $request) {
        $message = ['regex' => 'Password must contain atleast one upercase,one lowercase and one special character.'];
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation' => 'required|string|min:8',
            'email' => 'required|string|max:255|email|unique:users,email,NULL,id,deleted_at,NULL',
            'mobile_number' => 'required|string|unique:users',
            'user_type' => 'required'
        ];
        $validator = \Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $expiry_date = date("Y-m-d H:i:s", strtotime('+24 hours'));
        $transaction = DB::transaction(function () use ($data, $expiry_date) {
                    $user = new User();
                    $access_code = $this->unique_code(8);
                    $user->first_name = $data['first_name'];
                    $user->last_name = $data['last_name'];
                    $user->email = $data['email'];
                    $user->password = Hash::make($data['password']);
                    $user->mobile_number = $data['mobile_number'];
                    $user->expiry_date = $expiry_date;
                    $user->access_token = $access_code;
                    if($data['user_type'] == "user") {
                         $user->is_active = false;
                    }
                    if($data['user_type'] == "partner") {
                         $user->random_token = Str::random(10);
                    }
                    if ($user->save()) {
                        if ($data['user_type'] == "user") {
                            $roleUser = Role::where('name', config('constant.user_roles.user'))->first();
                            $user->roles()->attach($roleUser->id);
                        } elseif ($data['user_type'] == "partner") {
                            $rolePartner = Role::where('name', config('constant.user_roles.partner'))->first();
                            $user->roles()->attach($rolePartner->id);
                        } else {
                            
                        }
                        if ($data['user_type'] == "user")
                        {
                           $user->notify(new VerifyEmail($user->first_name, $access_code));  
                        }
                       
                        return true;
                    }
                });
        if ($transaction) {

            if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'is_active'=>'1'])) {
          
            if (Auth::user()->roles()->first()->name == 'User') {
                return redirect()->route('user.dashboard');
            } elseif (Auth::user()->roles()->first()->name == 'Partner') {
                return redirect()->route('partner.dashboard');
            }elseif (Auth::user()->roles()->first()->name == 'Administrator'){
                return redirect()->route('admin.dashboard');
            } else {
                
            }
        }
            return redirect()->route('thankyou');
        }
        return redirect()->back()->withInput()->withErrors('unable to create the user.');
    }

    private function unique_code($limit) {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public function showThankYouPage() {
        return view('thank_you');
    }

}
