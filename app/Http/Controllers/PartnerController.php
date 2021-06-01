<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Scholarship;
use App\Model\UserScholarship;

class PartnerController extends Controller
{

    public function index($active = null) {
        $user_id = Auth::user()->id;
        $activeScholarships = Scholarship::where('is_active', 1)->where('scholarships.partner_id',$user_id)->with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->get();
        if(count($activeScholarships)>0)
        {
            foreach($activeScholarships as $scholarships)
            {
                $scholarships->user_list=$this->getScholarshipApplyUserList($scholarships->id);
            }

        }


        $scholarshipHistory = Scholarship::where('scholarship_expiry_date', '<', date("Y-m-d"))->where('scholarships.partner_id',$user_id)->with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->get();
        $pendingScholarships =  Scholarship::where('scholarship_expiry_date', '>=', date("Y-m-d"))->where('is_active', 0)->where('scholarships.partner_id',$user_id)->with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->get();
        $declineScholarships = Scholarship::where('is_active', 2)->where('scholarships.partner_id',$user_id)->with(['user' => function($query) {
                        $query->select('id', 'first_name');
                    }])->get();
        
        $acive['active_scholar'] = '';
        $acive['new_scholar'] = '';
        if ($active != null) {
            $acive['active_scholar'] = 'active';
        } else {
            $acive['new_scholar'] = 'active';
        }
        $acive['scholar_history'] = '';
        $acive['pending_scholar']='';
        $acive['decline_scholar']='';
        return view('partner.dashboard', ['activeScholarships' => $activeScholarships, 'scholarshipHistory' => $scholarshipHistory, 'active' => $acive,'pendingScholarships'=>$pendingScholarships,'declineScholarships'=>$declineScholarships]);
    }

    public function getScholarshipApplyUserList($scholarshipId)
    {
        $userDetails=[];
        $userDetails=UserScholarship::leftjoin('users','users.id','user_scholarship.user_id')->where('user_scholarship.scholarship_id',$scholarshipId)->select('user_scholarship.user_id','users.first_name','user_scholarship.id as userScholarshipId')->get();

        return $userDetails;

    }

    public function initializePayment() {
        $curl = curl_init();

        $email = "your@email.com";
        $amount = 350000;  //the amount in kobo. This value is actually NGN 300
// url to go to after payment
        $callback_url = route('payment.callback');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'email' => $email,
                'callback_url' => $callback_url
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer sk_test_24234cd99895d03070e94d00e91c3b43df2a556e", //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);
        if (!$tranx['status']) {
            // there was an error from the API
            print_r('API returned error: ' . $tranx['message']);
        }
//        return view('user.payment');
// comment out this line if you want to redirect the user to the payment page
//        print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
//        header('Location: ' . $tranx['data']['authorization_url']);
    }

    public function paymentCallback() {
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {
            die('No reference supplied');
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer sk_test_36658e3260b1d1668b563e6d8268e46ad6da3273",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if (!$tranx->status) {
            // there was an error from the API
            die('API returned error: ' . $tranx->message);
        }

        if ('success' == $tranx->data->status) {
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value
            echo "<h2>Thank you for making a purchase. Your file has bee sent your email.</h2>";
        }
    }
    
     public function showProfile(Request $request) {
        $user = Auth::user();
        return view('partner.profile', ['user' => $user]);
    }
    

}
