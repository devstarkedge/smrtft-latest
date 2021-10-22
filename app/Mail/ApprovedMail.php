<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
     /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {

       
        $subject=" Your Account Approved in SMRTFT";

       return $this->subject($subject)->view('emails.approvedMail')->with('data',$this->data);
    }
}
