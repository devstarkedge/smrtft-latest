<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Model\Scholarship;
use App\Model\UserScholarship;
use App\Model\UserScholarshipUploadDocument;
use App\Model\Transaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ScholarshipApply;

class UserController extends Controller
{

    public function index(Request $request) {
        $user = Auth::user();
        $now = date("Y-m-d H:i:s");
        $isExpired = 0;
        if ($user->expiry_date < $now) {
            $isExpired = 1;
        }
        $userScholarship = UserScholarship::where('user_id', $user->id)->get();
        $scholarshipIds = [];
        if ($userScholarship->count() > 0) {
            $scholarshipIds = $userScholarship->pluck('scholarship_id');
        }
        $query=Scholarship::where('scholarships.is_active', 1)->whereNotIn('id', $scholarshipIds)->with('user');
        $orderby=!empty($request->slct_order)?$request->slct_order:"";
        if(empty($orderby))
        {
             $scholarships = $query->orderby('scholarships.id','desc')->paginate(6);
        }
        else
        {
             $scholarships = $query->orderby($orderby,'desc')->paginate(6);
        }
       

        
        return view('user.dashboard', ['user' => $user, 'scholarships' => $scholarships, 'isExpired' => $isExpired,'slct_order'=>$orderby]);
    }


    public function userAllScholarships(Request $request)
    {
        $user = Auth::user();
        $now = date("Y-m-d H:i:s");
        $isExpired = 0;
        if ($user->expiry_date < $now) {
            $isExpired = 1;
        }
        $userScholarship = UserScholarship::where('user_id', $user->id)->get();
        $scholarshipIds = [];
        if ($userScholarship->count() > 0) {
            $scholarshipIds = $userScholarship->pluck('scholarship_id');
        }
        $scholarships = Scholarship::where('is_active', 1)->whereNotIn('id', $scholarshipIds)->with('user')->orderby('scholarships.id','desc')->paginate(6);

        return view('user.all_scholarships', ['user' => $user, 'scholarships' => $scholarships, 'isExpired' => $isExpired]);

    }

    public function scholarshipDetails(Request $request,$scholarship_id)
    {
        $user = Auth::user();
        $now = date("Y-m-d H:i:s");
        $isExpired = 0;
        if ($user->expiry_date < $now) {
            $isExpired = 1;
        }
        
       $scholarshipDetails= Scholarship::where('scholarships.is_active', 1)->where('id', $scholarship_id)->with('user')->first();

        $checkscholarshipDetails=UserScholarship::where(['scholarship_id'=>$scholarship_id,'user_id'=>Auth::user()->id])->first();

       if(empty($checkscholarshipDetails))
       {
          return view('user.scholarship_details', ['scholarshipDetails' => $scholarshipDetails, 'isExpired' => $isExpired]);
       }
       else
       {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'You have  already apply for this Scholarship.');
            return redirect()->route('user.dashboard');
       }

      



    }

     public function scholarshipQuestionDetails(Request $request,$scholarship_id)
    {
        $user = Auth::user();
        $now = date("Y-m-d H:i:s");
        $isExpired = 0;
        if ($user->expiry_date < $now) {
            $isExpired = 1;
        }
        
       $scholarshipDetails= Scholarship::where('scholarships.is_active', 1)->where('id', $scholarship_id)->with('user')->first();

       $checkscholarshipDetails=UserScholarship::where(['scholarship_id'=>$scholarship_id,'user_id'=>Auth::user()->id])->first();

       if(empty($checkscholarshipDetails))
       {
         return view('user.scholarship_question_details', ['scholarshipDetails' => $scholarshipDetails, 'isExpired' => $isExpired]);
       }
       else
       {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'You have  already apply for this Scholarship.');
            return redirect()->route('user.dashboard');
       }
      



    }

    public function show(Request $request) {
        $user = Auth::user();
        return view('user.account', ['user' => $user]);
    }

    public function update(Request $request) {

        $user = User::where('id', Auth::user()->id)->first();
        $validator = \Validator::make($request->all(), [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'mobile_number' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $update = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'mobile_number' => $request['mobile_number'],
            'street' => $request['street'] ?? null,
            'city' => $request['city'] ?? null,
            'state' => $request['state'] ?? null,
            'school' => $request['school'] ?? null
        ];
        if ($request->has('intersts')) {
            $intersts = serialize($request['intersts']);
            $update['interests'] = $intersts;
        } else {
            $update['interests'] = '';
        }
        $updated = $user->update($update);

        if ($updated) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Account updated successfully.');
            return redirect()->back()->withInput()->withSuccess('Account updated successfully.');
        }
        return redirect()->back()->withInput()->withErrors('Error while updating the account.');
    }

    public function changePasswordForm() {
        return view('user.change_password');
    }

    public function changeUserPasword(Request $request) {
        $rules = array(
            'current_password' => 'required|min:3',
            'password_confirmation' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password' => 'required|same:password_confirmation|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        );
        $messages = ['regex' => 'Password must contain atleast one upercase,one lowercase and one special character.'];
        $data = $request->all();
        $validator = \Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $user = Auth::user();
        if (Hash::check($data['password'], $user->password)) {
            return redirect()->back()->withErrors('New password same as old password.');
        } else if (!Hash::check($data['current_password'], $user->password)) {
            return redirect()->back()->withErrors('Wrong current password.');
        } else {
            
        }

        $update = $user->update(['password' => Hash::make($data['password'])]);

        if ($update) {
            return redirect()->back()->withSuccess('Password updated successfully.');
        }
        return redirect()->back()->withErrors('Error while updating the password.');
    }

    public function applyScholarship(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'scholarship_id' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $scholaship = UserScholarship::create([
                    'scholarship_id' => $request['scholarship_id'],
                    'user_id' => Auth::user()->id,
                    'is_status' => 0,
        ]);
        if ($scholaship) {

            $scholarshipDetails=Scholarship::where('id', $request['scholarship_id'])->first();
            $userDetails=User::find(Auth::user()->id);
            $useremail=$userDetails->email;

            $data=array("scholarship_name"=>$scholarshipDetails->scholarship_name,"scholarship_amount"=>$scholarshipDetails->scholarship_amount);
            

            Mail::to($useremail)->send(new ScholarshipApply($data));

            return response()->json(['success' => 'successfully applied.']);
        }
        return response()->json(['error' => 'Error applying scholarship.']);
    }

        public function userApplyScholarship(Request $request) {
             $rules = [
                    'scholarship_id' => 'required',
                    'professional_life' => 'required',
                  ];
              $messages = [        
                 'citizen_permanent.required' => 'please select list of citizen or permanent.',
                 'experience_five_year.required'=>'please select you have five year accmulative gap or not.',
                 'professional_life.required'=>'please Enter your essay .'              
             ];
        // $validator = \Validator::make($request->all(), [
        //             'scholarship_id' => ['required'],
        //             'citizen_permanent'=>['required'],
        //             'experience_five_year'=>['required'],
        //             'professional_profile'=>['required']

        // ]);

               $validator = \Validator::make($request->all(),$rules,$messages );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $scholarship_doc_one="";

       
        $scholaship = UserScholarship::create([
                    'scholarship_id' => $request['scholarship_id'],
                    'user_id' => Auth::user()->id,
                    'is_status' => 0,
                    'professional_life'=>$request['professional_life'],
                    'user_submit_doc'=>$scholarship_doc_one
        ]);
        if ($scholaship) {

            $user_scholarship_id=$scholaship->id;

            if(count($request->file('user_upload_doc'))>0)
            {
                $uploadDocuments=$request->file('user_upload_doc');
                $i=1;
                foreach ($uploadDocuments as  $uploadDoc) {
                    if(!empty($uploadDoc))
                    {
                       if ($files = $uploadDoc) {
             
                       $destinationPath = 'myscholarship_docs/user_submit_doc'; // upload path
                      // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
                       $scholarship_doc = "user_submit".date('YmdHis').$i.".".$files->getClientOriginalExtension();
                       $files->move($destinationPath, $scholarship_doc);

                       UserScholarshipUploadDocument::create(['user_scholarship_id'=>$user_scholarship_id,'upload_doc'=>$scholarship_doc]);
                    }
                    $i++; 
                    }
                    
                }

            }

             

            $scholarshipDetails=Scholarship::where('id', $request['scholarship_id'])->first();
            $userDetails=User::find(Auth::user()->id);
            $useremail=$userDetails->email;

            $data=array("scholarship_name"=>$scholarshipDetails->scholarship_name,"scholarship_amount"=>$scholarshipDetails->scholarship_amount);
            

            Mail::to($useremail)->send(new ScholarshipApply($data));

             $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Application Received.');
             return redirect()->route('user.dashboard');
        }
        
    }

    public function cancelScholarship(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                    'user_scholarship_id' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $scholaship = UserScholarship::where('id',$request->user_scholarship_id)->delete();
        if ($scholaship) {
            return response()->json(['success' => 'cancel applied.']);
        }
        return response()->json(['error' => 'Error cancelling scholarship.']);




    }

    public function makeTransaction(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'transaction_id' => ['required'],
                    'plan_id' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $plan = \App\Model\Plan::where('id', $request['plan_id'])->first();

        $userDetails= User::where('id', Auth::user()->id)->first();
        $oldExpiryDate=$userDetails->expiry_date;
        $now=date('Y-m-d H:i:s');
        if ($plan->plan_period == 'annually') {
            $addMonth = '1 year';
        }
         if ($plan->plan_period == 'monthly') {
            $addMonth = $plan->time_period.' month';
        }
        if(strtotime($now)>strtotime($oldExpiryDate))
        {
            $expiryDate = date('Y-m-d H:i:s', strtotime(' +' . $addMonth));
        }
        else
        {
             $expiryDate = date('Y-m-d H:i:s', strtotime(' +' . $addMonth, strtotime($oldExpiryDate)));
        }
       
        $transaction = Transaction::create([
                    'user_id' => Auth::user()->id,
                    'plan_id' => $request['plan_id'],
                    'transaction_number' => $request['transaction_id'],
                    'plan_expiry'=>$expiryDate
        ]);

        User::where('id', Auth::user()->id)->update(['expiry_date' => $expiryDate]);
        if ($transaction) {
            return response()->json(['success' => 'successfully buyed.']);
        }
        return response()->json(['error' => 'Error applying purchasing the plan.']);
    }

}
