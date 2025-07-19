<?php

namespace App\Events;

use App\Models\Lot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LotReserved implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $lot;

    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    public function broadcastOn()
    {
        return new Channel('lots'); // You can use PrivateChannel if you want auth
    }

    public function broadcastAs()
    {
        return 'LotReserved';
    }

    public function broadcastWith()
    {
        return [
            'lot_id' => $this->lot->id,
            'lot_number' => $this->lot->lot_number,
            'status' => $this->lot->status,
        ];
    }
}
