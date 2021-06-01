<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Scholarship;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScholarshipController extends Controller
{

    public function index(Request $request) {
        $user = Auth::user();
        $scholarships = Scholarship::leftjoin('users', 'users.id', 'scholarships.partner_id')->where('partner_id', $user->id)->select('scholarships.id', 'scholarship_name', 'scholarship_expiry_date','is_active', 'scholarship_amount', 'users.first_name as name')->get();
        return view('partner.scholarships.index')->with(['scholarships' => $scholarships]);
    }

    public function create(Request $request) {
        return view('partner.scholarships.create');
    }

    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'scholarship_name' => 'required',
                    'scholarship_expiry_date' => 'required',
                    'awards'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        
        $scholarship = new Scholarship();
        $scholarship->scholarship_name = $data['scholarship_name'];
        $scholarship->scholarship_amount = !empty($data['scholarship_amount'])?$data['scholarship_amount']:0;
        $scholarship->scholarship_expiry_date = Carbon::parse($data['scholarship_expiry_date']);
        $scholarship->awards=$data['awards'];
        $scholarship->partner_id = Auth::id();
        $scholarship->instruction=$data['instruction'];
        $scholarship_doc_one="";
        $scholarship_doc_two="";
        $scholarship_doc_three="";
       
        // if ($files = $request->file('file_one')) {
            
        //    $destinationPath = 'myscholarship_docs/'; // upload path
        //   // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
        //    $scholarship_doc_one = "first_".date('YmdHis').".".$files->getClientOriginalExtension();
        //    $files->move($destinationPath, $scholarship_doc_one);
        // }

        // if ($files1 = $request->file('file_two')) {
            
        //    $destinationPath = 'myscholarship_docs/'; // upload path
        //   // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
        //    $scholarship_doc_two = "second_".date('YmdHis').".".$files1->getClientOriginalExtension();
        //    $files1->move($destinationPath, $scholarship_doc_two);
        // }

        // if ($files2 = $request->file('file_three')) {
            
        //    $destinationPath = 'myscholarship_docs/'; // upload path
        //   // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
        //    $scholarship_doc_three = "second_".date('YmdHis').".".$files2->getClientOriginalExtension();
        //    $files2->move($destinationPath, $scholarship_doc_three);
        // }
        
        $scholarship->scholarship_doc_one=$scholarship_doc_one;
        $scholarship->scholarship_doc_two=$scholarship_doc_two;
        $scholarship->scholarship_doc_three=$scholarship_doc_three;
        if (Auth::user()->roles()->first()->name == 'Administrator')
        {
             $scholarship->is_active = 1;
        }
        else
        {
            $scholarship->is_active = 0; 
        }
        // $scholarship->is_active = $data['is_active'] ?? 0;
        if ($scholarship->save()) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Scholarship Succesfully Summited for Review.');
            return redirect()->route('partner.dashboard','active-scholar');
        }
        else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while Added scholarship.');
        }
    }

    public function edit(Request $request, $id) {
        $scholarship = Scholarship::where('id', $id)->first();
        return view('partner.edit')->with(['scholarship' => $scholarship]);
    }

    public function update(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
                    'scholarship_name' => 'required',
                    'scholarship_expiry_date' => 'required',
                    'awards'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $scholarship = Scholarship::where('id', $id)->first();
        $scholarship->scholarship_name = $data['scholarship_name'];
        $scholarship->scholarship_amount = !empty($data['scholarship_amount'])?$data['scholarship_amount']:0;
        $scholarship->scholarship_expiry_date = Carbon::parse($data['scholarship_expiry_date']);
        $scholarship->awards=$data['awards'];
        $scholarship->partner_id = Auth::id();
         $scholarship->instruction=$data['instruction'];
        $scholarship_doc_one=$scholarship->scholarship_doc_one;
        $scholarship_doc_two=$scholarship->scholarship_doc_two;
        $scholarship_doc_three=$scholarship->scholarship_doc_three;
       
       // if($request->file('file_one')!=null){
       //  if ($files = $request->file('file_one')) {
            
       //     $destinationPath = 'myscholarship_docs/'; // upload path
       //    // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
       //     $scholarship_doc_one = "first_".date('YmdHis').".".$files->getClientOriginalExtension();
       //     $files->move($destinationPath, $scholarship_doc_one);
       //  }
       //  }

       //  if($request->file('file_two')!=null){
       //  if ($files1 = $request->file('file_two')) {
            
       //     $destinationPath = 'myscholarship_docs/'; // upload path
       //    // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
       //     $scholarship_doc_two = "second_".date('YmdHis').".".$files1->getClientOriginalExtension();
       //     $files1->move($destinationPath, $scholarship_doc_two);
       //  }
       //  }

       //  if($request->file('file_three')!=null){

       //  if ($files2 = $request->file('file_three')) {
            
       //     $destinationPath = 'myscholarship_docs/'; // upload path
       //    // url('storage/subserviceImages/'.$SubServicesList['sub_service_image']);  
       //     $scholarship_doc_three = "second_".date('YmdHis').".".$files2->getClientOriginalExtension();
       //     $files2->move($destinationPath, $scholarship_doc_three);
       //  }
       // }
        
        $scholarship->scholarship_doc_one=$scholarship_doc_one;
        $scholarship->scholarship_doc_two=$scholarship_doc_two;
        $scholarship->scholarship_doc_three=$scholarship_doc_three;
        if ($scholarship->save()) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Scholarship Updated Successfully.');
            return redirect()->route('partner.dashboard','active-scholar');
        }
        else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while Updated scholarship.');
        }
        return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    public function destroy(Request $request, $id) {
        $scholarship = Scholarship::where('id', $id)->first();
        if ($scholarship->delete()) {
            return redirect()->route('scholarships.index');
        }
        return redirect()->route('scholarships.index');
    }

}
