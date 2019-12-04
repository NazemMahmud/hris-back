<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class GenericRedisEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $key;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($entityModel)
    {
        $reflection = new \ReflectionClass($entityModel);
        $model_name = $reflection->getShortName();
        $this->key = $model_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
