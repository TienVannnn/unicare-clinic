<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected  $name, $email, $token;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('admin.mail.verifyEmail')->with([
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token
        ]);
    }
}
