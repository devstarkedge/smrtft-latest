<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SignupSuccess;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PasswordController extends Controller
{

    public function showAccessCodeForm(Request $request)
    {
        $token = $request->access_code;
        return view('auth.passwords.access_code', ['token' => $token]);
    }

    public function showGeneratePasswordForm(Request $request)
    {
        $code = $request->access_code;
        $user = User::where('access_token', $code)->first();
        if (!empty($user)) {
            return view('auth.passwords.early_access_signup', ['user' => $user]);
        }
        return redirect()->back()->withErrors('invalid token');
    }

    public function update_user_password(Request $request)
    {
        $rules = array(
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'access_token' => 'required',
            'user_id' => 'required'
        );
        $messages = ['regex' => 'Password must contain atleast one upercase,one lowercase and one special character.'];
        $data = $request->all();
        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $user_update = User::where(['id' => $request['user_id'], 'access_token' => $request['access_token']])->update(['password' => Hash::make($request['password']), 'access_token' => null, 'email_verified_at' => Carbon::now()->toDateTimeString()]);
        if ($user_update) {
            Auth::loginUsingId($request['user_id']);
            $user = Auth::user();
            $user->notify(new SignupSuccess($user->first_name));
            return redirect()->route('user.dashboard');
        }
        return redirect()->back()->withErrors('error while updating the password.');
    }

}
