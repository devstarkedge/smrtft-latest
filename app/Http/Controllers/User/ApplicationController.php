<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserScholarship;
use App\Model\Plan;
use App\Model\Transaction;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

    public function index() {
        $userScholarships = UserScholarship::leftjoin('scholarships', 'user_scholarship.scholarship_id', 'scholarships.id')->where('user_scholarship.user_id', auth()->id())->select('user_scholarship.id','scholarships.scholarship_amount','scholarships.scholarship_name','scholarships.scholarship_expiry_date','user_scholarship.is_status')->orderby('user_scholarship.id','desc')->paginate(6);
        return view('user.my_applications')->with(['userScholarships' => $userScholarships]);
    }

     public function myAllApplications() {
        $userScholarships = UserScholarship::where('user_id', auth()->id())->leftjoin('scholarships', 'user_scholarship.scholarship_id', 'scholarships.id')->orderby('user_scholarship.id','desc')->paginate(6);
        return view('user.my_all_applications')->with(['userScholarships' => $userScholarships]);
    }

    public function getPlans() {
        $monthlyPlans = Plan::where('plan_period', 'monthly')->with('transaction')->get();
        $annualPlans = Plan::where('plan_period', 'annually')->with('transaction')->get();
        
        return view('user.membership')->with(['annualPlans' => $annualPlans, 'monthlyPlans' => $monthlyPlans]);
    }
    
    public function planSuccess() {
        return view('user.payment-success');
    }
    
    public function planFailure() {
        return view('user.payment-failure');
    }

}
