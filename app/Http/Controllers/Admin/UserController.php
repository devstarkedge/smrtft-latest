<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserNotify;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index() {
        $users = User::whereHas('roles', function($query) {
                    $query->where('name', '!=', 'Administrator');
                })->with('roles')->orderby('users.id','desc')->get();

        $is_admin=(Auth::user()->roles()->first()->name=='Administrator')?1:0;

        
        return view('admin.user.index')->with(['users' => $users,'is_admin'=>$is_admin]);
    }

    public function create() {
        $roles = Role::where('name', '!=', 'Administrator')->get();
        return view('admin.user.create')->with(['roles' => $roles]);
    }

    public function save(Request $request) {
        $message = ['regex' => 'Password must contain atleast one upercase,one lowercase and one special character.'];
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation' => 'required|string|min:8',
            'email' => 'required|string|max:255|email|unique:users',
            'mobile_number' => 'required|string|unique:users',
            'role' => 'required'
        ];
        $validator = \Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $expiry_date = date("Y-m-d H:i:s", strtotime('+24 hours'));
        $transaction = DB::transaction(function () use ($data, $expiry_date) {
                    $user = User::create([
                                'first_name' => $data['first_name'],
                                'last_name' => $data['last_name'],
                                'email' => $data['email'],
                                'password' => Hash::make($data['password']),
                                'mobile_number' => $data['mobile_number'],
                                'expiry_date' => $expiry_date,
                                'is_active' => $data['is_active'] ?? 0
                    ]);
                    if ($user) {
                        $role = Role::where('name', $data['role'])->first();
                        $user->roles()->attach($role->id);
                        $user->notify(new UserNotify($data['email'], $data['password']));
                        return true;
                    }
                    return false;
                });
        if ($transaction) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'User created Successfully.');
            return redirect()->route('admin.users.index');
        }
        return redirect()->back()->withInput()->withErrors('unable to create the user.');
    }

    public function edit(Request $request, $id) {
        $user = User::where('id', $id)->with('roles')->first();
        $roles = Role::where('name', '!=', 'Administrator')->get();
        return view('admin.user.create')->with(['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id) {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:users,mobile_number,' . $id,
            'role' => 'required'
        ];
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        try {
            $update['first_name'] = $data['first_name'];
            $update['last_name'] = $data['last_name'];
            $update['mobile_number'] = $data['mobile_number'];
            $update['is_active'] = $data['is_active'];
            $user = User::where('id', $id)->update($update);
            if ($user) {
                $userInfo = User::where('id', $id)->with('roles')->first();
                if ($data['role'] != $userInfo->roles[0]->name) {
                    $role = Role::where('name', $data['role'])->first();
                    $userInfo->roles()->sync([$role->id]);
                }
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'User Updated Successfully.');
                return redirect()->route('admin.users.index');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }
        return redirect()->back()->withInput()->withErrors('unable to update the user.');
    }

    public function destroy(Request $request, $id) {
        $user = User::where('id', $id)->delete();
        if ($user) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'User Deleted Successfully.');
            return redirect()->route('admin.users.index');
        }
        return redirect()->back()->withInput()->withErrors('unable to delete the user.');
    }

}
