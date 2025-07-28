<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public int $user_id;
    public string $user_name;

    public function __construct($message, $user_id)
    {
        $this->user_id = $user_id;
        $this->message = $message;
        $this->user_name = auth()->user()->name; 
    }

    public function broadcastOn(): Channel
    {
        return new Channel('messages');
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
        ];
    }
}
