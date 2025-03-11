<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $name;
    public $count;

    /**
     * Create a new event instance.
     */
    public function __construct($name, $count)
    {
        $this->name = $name;
        $this->count = $count;
    }

    public function broadcastOn()
    {
        return new Channel('appointment-channel');
    }

    public function broadcastAs()
    {
        return 'appointment-created';
    }

    public function broadcastWith()
    {
        return [
            'name' => $this->name,
            'count' => $this->count,
        ];
    }
}
