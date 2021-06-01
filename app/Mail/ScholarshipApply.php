<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScholarshipApply extends Mailable
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

       
        $subject=" Scholarship Applied For".$this->data['scholarship_name'];

       return $this->subject($subject)->view('emails.scholarship_apply')->with('data',$this->data);
    }
}
