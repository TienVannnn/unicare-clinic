<?php

namespace App\Jobs;

use App\Mail\MailAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin, $rand;
    /**
     * Create a new job instance.
     */
    public function __construct($admin, $rand)
    {
        $this->admin = $admin;
        $this->rand = $rand;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->admin->email)->send(new MailAccount($this->admin, $this->rand));
    }
}
