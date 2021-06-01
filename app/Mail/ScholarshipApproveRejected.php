<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScholarshipApproveRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $status;

    public $scholarshipDetails;

    public $userDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status,$scholarshipDetails,$userDetails)
    {
         $this->status = $status;
          $this->scholarshipDetails = $scholarshipDetails;
          $this->userDetails=$userDetails;
    }

    /**
     * Build the message.
     *
     * @return $thi
     */
    public function build()
    {
        $statustext=!empty($this->status=="1")?"Approved":"Declined";
       $subject="Your ".$this->scholarshipDetails['scholarship_name'] ." Scholarship is " .$statustext;

       return $this->subject($subject)->view('emails.approve_reject_scholarship')->with(['scholarshipDetails'=>$this->scholarshipDetails,'statustext'=>$statustext,'userDetails'=>$this->userDetails]);
    }
}
