<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendAutoResponseToCustomer
{
    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        $sender = User::find($event->message->sender_id);

        // Only send auto-response if sender is a customer
        if ($sender && $sender->role === 'customer') {

            // Get the conversation to find the admin
            $conversation = $event->message->conversation()->with('users')->first();
            $admin = $conversation->users->firstWhere('role', 'admin'); // Assuming you have admin role

            if (!$admin) {
                Log::warning('No admin found in conversation ID: ' . $event->message->conversation_id);
                return;
            }

            // Create auto-response from admin
            $autoMessage = Message::create([
                'body' => 'Your message has been received, please wait while we connect you to a representative.',
                'sender_id' => $admin->id, // Admin sends the auto-response
                'conversation_id' => $event->message->conversation_id,
            ]);

            // Broadcast the auto-response back to the customer
            broadcast(new MessageSent($autoMessage, $sender->id));

            Log::info('Auto-response sent to customer ID: ' . $sender->id);
        }
    }
}
