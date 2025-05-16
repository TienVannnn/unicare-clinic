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
    public $id;
    public $count;
    public $doctor;

    /**
     * Create a new event instance.
     */
    public function __construct($name, $id, $count, $doctor)
    {
        $this->name = $name;
        $this->id = $id;
        $this->count = $count;
        $this->doctor = $doctor;
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
            'id' => $this->id,
            'count' => $this->count,
            'doctor' => $this->doctor,
        ];
    }
}
