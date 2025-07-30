<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('sender');
    }

    public function broadcastOn()
    {
        logger("Broadcasting to: chat." . $this->message->conversation_id);
        return new PrivateChannel('chat.' . $this->message->conversation_id);
    }

    public function broadcastAs()
    {
        return 'message.sent'; // 👈 this is the event name
    }

    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
