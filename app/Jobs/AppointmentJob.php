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

    protected $userId, $token, $isNew, $pass;

    public function __construct($userId, $token, $isNew, $pass)
    {
        $this->userId = $userId;
        $this->token = $token;
        $this->isNew = $isNew;
        $this->pass = $pass;
    }

    public function handle(): void
    {
        $user = User::find($this->userId);

        if ($user && $user->email) {
            Mail::to($user->email)->send(new AppointmentMail($user, $this->token, $this->isNew, $this->pass));
        }
    }
}
