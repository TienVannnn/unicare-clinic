<?php

namespace App\Jobs;

use App\Mail\ContactReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ContactReplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $title, $email, $content;
    /**
     * Create a new job instance.
     */
    public function __construct($title, $email, $content)
    {
        $this->title = $title;
        $this->email = $email;
        $this->content = $content;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new ContactReply($this->title, $this->content));
    }
}
