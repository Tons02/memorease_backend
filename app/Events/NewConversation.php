<?php

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewConversation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;
    public $receiverId;

    public function __construct(Conversation $conversation, $receiverId)
    {
        $this->conversation = $conversation;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("chat.{$this->receiverId}");
    }

    public function broadcastAs(): string
    {
        return 'conversation.created';
    }
}
