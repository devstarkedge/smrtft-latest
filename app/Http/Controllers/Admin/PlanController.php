<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Plan;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{

    public function index(Request $request) {
        $plans = Plan::get();
        $is_admin=(Auth::user()->roles()->first()->name=='Administrator')?1:0;

        return view('admin.plans.index')->with(['plans' => $plans,'is_admin'=>$is_admin]);
    }

    public function create(Request $request) {
        return view('admin.plans.create');
    }

    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'plan_name' => ['required'],
                    'amount' => ['required'],
                    'plan_period' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $plan = new Plan();
        $plan->plan_name = $data['plan_name'];
        $plan->amount = $data['amount'];
        $plan->plan_period = $data['plan_period'];
        $plan->discount_amount=!empty($data['discount_amount'])?$data['discount_amount']:"";
        if ($plan->save()) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Plan added Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while adding plan');
        }
        return redirect()->route('plans.index');
    }

    public function edit(Request $request, $id) {
        $plan = Plan::where('id', $id)->first();
        return view('admin.plans.create')->with(['plan' => $plan]);
    }

    public function update(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
                    'plan_name' => ['required'],
                    'amount' => ['required'],
                    'plan_period' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $plan = Plan::where('id', $id)->first();
        if (!empty($plan)) {
            $plan->plan_name = $data['plan_name'];
            $plan->amount = $data['amount'];
            $plan->plan_period = $data['plan_period'];
            $plan->discount_amount=!empty($data['discount_amount'])?$data['discount_amount']:"";
            if ($plan->save()) {
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Plan Updated Successfully.');
            }
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while updating plan.');
        }
        return redirect()->route('plans.index');
    }

    public function destroy(Request $request, $id) {
        $plan = Plan::where('id', $id)->delete();
        if ($plan) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Plan Deleted Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while deleting plan.');
        }
        return redirect()->route('plans.index');
    }

}
