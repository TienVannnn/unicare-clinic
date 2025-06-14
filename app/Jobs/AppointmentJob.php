<?php

namespace App\Jobs;

use App\Mail\AppointmentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AppointmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user, $token, $isNew, $pass;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $token, $isNew, $pass)
    {
        $this->user = $user;
        $this->token = $token;
        $this->isNew = $isNew;
        $this->pass = $pass;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new AppointmentMail($this->user, $this->token, $this->isNew, $this->pass));
    }
}
