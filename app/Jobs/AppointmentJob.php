<?php

namespace App\Jobs;

use App\Mail\AppointmentMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AppointmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $token, $isNew, $pass;

    public function __construct($email, $token, $isNew, $pass)
    {
        $this->email = $email;
        $this->token = $token;
        $this->isNew = $isNew;
        $this->pass = $pass;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new AppointmentMail($this->email, $this->token, $this->isNew, $this->pass));
    }
}
