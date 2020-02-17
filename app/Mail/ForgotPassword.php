<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable{
    use Queueable, SerializesModels;
    public $codeRestoration;
    
    public function __construct($codeRestoration){
        $this->codeRestoration = $codeRestoration;
    }

    public function build(){
        return $this->view('mails.forgot_password');
    }
}
