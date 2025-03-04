<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $name;
    public $count;


    public function __construct($title, $name, $count)
    {
        $this->title = $title;
        $this->name = $name;
        $this->count = $count;
    }

    public function broadcastOn()
    {
        return new Channel('contact-channel');
    }


    public function broadcastAs()
    {
        return 'contact-created';
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'count' => $this->count,
        ];
    }
}
