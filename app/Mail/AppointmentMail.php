<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $email, $token, $isNew, $pass;
    public function __construct($email, $token, $isNew, $pass)
    {
        $this->email = $email;
        $this->token = $token;
        $this->isNew = $isNew;
        $this->pass = $pass;
    }

    public function build()
    {
        return $this->subject('Thông báo đặt lịch hẹn khám')
            ->view('admin.mail.appointment')
            ->with([
                'token' => $this->token,
                'isNew' => $this->isNew,
                'pass' => $this->pass,
            ]);
    }
}
