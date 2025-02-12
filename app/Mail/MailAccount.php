<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailAccount extends Mailable
{
    use Queueable, SerializesModels;
    protected $admin, $rand;
    /**
     * Create a new message instance.
     */
    public function __construct($admin, $rand)
    {
        $this->admin = $admin;
        $this->rand = $rand;
    }

    public function build()
    {
        return $this->view('admin.mail.mailaccount')->with(
            [
                'email' => $this->admin->email,
                'pass' => $this->rand
            ]
        );
    }
}
