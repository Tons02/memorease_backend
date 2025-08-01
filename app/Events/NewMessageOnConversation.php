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

class NewMessageOnConversation implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function broadcastOn()
    {
        return new Channel('conversation');
    }

    public function broadcastAs()
    {
        return 'LotReserved';
    }

    public function broadcastWith()
    {
        return [
            'conversation_id' => $this->conversation->id,
            'lot_number' => $this->conversation->lot_number,
            'status' => $this->conversation->status,
            'user_id' => $this->conversation->user_id,
        ];
    }
}
