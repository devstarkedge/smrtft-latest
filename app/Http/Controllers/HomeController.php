<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Setting;
use App\Model\FrequentlyAskedQuestion;
use App\Model\Scholarship;
use App\Model\ContactUs;
use App\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function index(Request $request) {
        $settings = Setting::first();
        $faqs = FrequentlyAskedQuestion::limit(7)->get();
        $scholarships = Scholarship::with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->where('is_active', 1)->whereDate('scholarship_expiry_date', '>=', Carbon::now()->toDateString())->limit(6)->orderby('scholarships.id','desc')->get();
        $searchText = null;
        if ($request->has('search_text')) {
            $searchText = $request->search_text;
        }
        if ($searchText != null) {
            $date = (bool) strtotime($searchText);
            if ($date) {
                $searchText = date("Y-m-d", strtotime($searchText));
            }
         
                 $scholarships = Scholarship::where('scholarships.is_active', 1)->whereDate('scholarship_expiry_date', '>=', Carbon::now()->toDateString())->where('scholarship_name', 'LIKE', "%$searchText%")
                            ->orWhere('scholarship_amount', 'LIKE', "%$searchText%")
                            ->orWhere('scholarship_expiry_date', 'LIKE', "%$searchText%")
                            ->orWhereHas('user', function ($query) use ($searchText) {
                                $query->where('first_name', 'like', '%' . $searchText . '%');
                            })
                            ->with('user')->limit(6)->orderby('scholarships.id','desc')->get();
        }
        return view('home')->with(['settings' => $settings, 'faqs' => $faqs, 'scholarships' => $scholarships]);
    }

    public function searchScholarships(Request $request)
    {
         $searchText = null;
        if ($request->has('search_text')) {
            $searchText = $request->search_text;
        }
        if ($searchText != null) {
            $date = (bool) strtotime($searchText);
            if ($date) {
                $searchText = date("Y-m-d", strtotime($searchText));
            }
         
                 $scholarships = Scholarship::where('scholarships.is_active', 1)->whereDate('scholarship_expiry_date', '>=', Carbon::now()->toDateString())->where('scholarship_name', 'LIKE', "%$searchText%")
                            ->orWhere('scholarship_amount', 'LIKE', "%$searchText%")
                            ->orWhere('scholarship_expiry_date', 'LIKE', "%$searchText%")
                            ->orWhereHas('user', function ($query) use ($searchText) {
                                $query->where('first_name', 'like', '%' . $searchText . '%');
                            })
                            ->with('user')->limit(6)->orderby('scholarships.id','desc')->get();
        }

        return view('search-scholarships')->with([ 'scholarships' => $scholarships]);


    }

    public function getAllFaqs(Request $request) {
        $faqs = FrequentlyAskedQuestion::get();
        return view('faqs')->with(['faqs' => $faqs]);
    }

    public function contactUs() {
        return view('contact-us');
    }

    public function privacyPolicy() {
        return view('privacy-policy');
    }

    public function termsConditions() {
        return view('terms-conditions');
    }

    public function successStories() {
        return view('success-stories');
    }
     public function studentSuccess() {
        return view('student-success');
    }

    public function about() {
        return view('about');
    }

    public function fraudAlert() {
        return view('fraud-alert');
    }

    public function unauthorized() {
        return view('401');
    }

   
    public function allScholarships(Request $request) {

        $orderby=!empty($request->slct_order)?$request->slct_order:"";
        $query = Scholarship::with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->where('scholarships.is_active', 1)->whereDate('scholarship_expiry_date', '>=', Carbon::now()->toDateString());
        if(empty($orderby))
        {
             $scholarships = $query->orderby('scholarships.id','desc')->paginate(6);
        }
        else
        {
             $scholarships = $query->orderby($orderby,'desc')->paginate(6);
        }
        return view('all-scholarships')->with(['scholarships' => $scholarships,'slct_order'=>$orderby]);
    }

    public function contactUsSubmit(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
        $data = $request->all();
        $contact = new ContactUs();
        $contact->first_name = $data['first_name'];
        $contact->last_name = $data['last_name'] ?? null;
        $contact->email = $data['email'] ?? null;
        $contact->subject = $data['subject'] ?? null;
        $contact->message = $data['message'] ?? null;
        if ($contact->save()) {
            Mail::send([], [], function ($message) use ($data){
                $message->to('manpreet.kaur.starkedge@yopmail.com')->subject('Contact us form submit')
                ->setBody('Hi, Some user has submitted the contact us form Here is the details Name :'.$data['first_name'].'Last Name:'.$data['first_name'].'Email:'.$data['email'].'Phone:'.$data['phone'].'subject:'.$data['subject'].'message:'.$data['message']);
            });
            return redirect()->route('thankyou');
        }
        return redirect()->route('home');
    }


    public function sponserScholarshipsDetails(Request $request,$random_token)
    {

       $sponserDetails= User::leftjoin('role_user','users.id','role_user.user_id')->where('users.random_token',$random_token)->where('role_user.role_id',2)->select('users.id','users.first_name')->first();
        if(!empty($sponserDetails))
        {
            $username=$sponserDetails->first_name;
            $scholarships=Scholarship::with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->where('scholarships.is_active', 1)->whereDate('scholarship_expiry_date', '>=', Carbon::now()->toDateString())->where('scholarships.partner_id',$sponserDetails->id)->orderby('scholarships.id','desc')->get();

             return view('sponser_scholarships_details')->with(['scholarships' => $scholarships,'username'=>$username]);
             
        }
        else
        {

             return abort(404);
        }



    }

}
