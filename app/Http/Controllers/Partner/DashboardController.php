<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\UserScholarship;
use App\Model\UserScholarshipUploadDocument;
use App\Model\Scholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ScholarshipApproveRejected;

class DashboardController extends Controller
{

    public function index() {
        $users = User::where('is_active', 1)->whereHas('roles', function($query) {
                    $query->where('name', '=', 'User');
                })->get();

        $userId= Auth::user()->id;

       // $applications = UserScholarship::has('user','scholarship')->with(['user', 'scholarship'])->get();

        $applications=UserScholarship::leftjoin('scholarships','scholarships.id','user_scholarship.scholarship_id')->leftjoin('users','users.id','user_scholarship.user_id')->where('scholarships.partner_id',$userId)->select('*','user_scholarship.id as userScholarshipId')->get();
        return view('partner.users_list')->with(['users' => $users, 'applications' => $applications]);
    }

    public function approveScholarship(Request $request) {
        try {

            $approve = UserScholarship::where(['scholarship_id' => $request['scholarship_id'], 'user_id' => $request['user_id']])->update(['is_status' => $request['status']]);
            if ($approve) {
                $status= $request['status'];
                $scholarshipDetails=Scholarship::where('id', $request['scholarship_id'])->first();
                $userDetails=User::where('id',$request['user_id'])->first();
                $useremail=$userDetails->email;
                 Mail::to($useremail)->send(new ScholarshipApproveRejected($status,$scholarshipDetails,$userDetails));
                return response()->json(['status' => true, 'message' => 'successfully status changed.']);
            }
        } catch (\Exception $ex) {

            return response()->json(['status' => false, 'message' => $ex->getMessage()]);
        }
        return response()->json(['status' => false, 'message' => 'Error while changing status.']);
    }


    public function userApplicationDetails(Request $request,$user_scholarship_id)
    {
        $applications=UserScholarship::where('user_scholarship.id',$user_scholarship_id)->leftjoin('scholarships','scholarships.id','user_scholarship.scholarship_id')->leftjoin('users','users.id','user_scholarship.user_id')->first();
        $uploadDocumentDetails=UserScholarshipUploadDocument::where('user_scholarship_id',$user_scholarship_id)->get();
        return view('partner.users_application_details')->with(['applications' => $applications,'uploadDocumentDetails'=>$uploadDocumentDetails]);

    }
}
