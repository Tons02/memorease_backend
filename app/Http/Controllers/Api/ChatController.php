<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use ApiResponse;
    // Get all conversations for the authenticated user
    public function conversations()
    {
        $user = Auth::user();
        $conversations = $user->conversations()->with(['users', 'messages' => function ($query) {
            $query->latest()->limit(1); // Get last message
        }])->get();

        return $this->responseSuccess('Conversation display successfully', $conversations);
    }

    // Get all messages in a specific conversation
    public function messages($conversationId)
    {
        $conversation = Conversation::with('messages.sender')->findOrFail($conversationId);

        // Optional: Update last_read_at for the user
        $conversation->users()->updateExistingPivot(Auth::id(), ['last_read_at' => now()]);


        return $this->responseSuccess('Conversation display successfully', $conversation);
    }

    // Send a new message
    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::id(),
            'body' => $request->content,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $this->responseSuccess('Message Send successfully', $message);
    }

    // Optional: create new private conversation between two users
    public function startPrivateChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = auth('sanctum')->user();

        $fullName = trim(
            "{$user->fname} " .
                ($user->mi ? "{$user->mi}. " : "") .
                "{$user->lname} " .
                ($user->suffix ? "{$user->suffix}" : "")
        );

        $authUserId = Auth::id();
        $otherUserId = $request->user_id;

        // Check if a private chat already exists
        $conversation = Conversation::where('type', 'private')
            ->whereHas('users', fn($q) => $q->where('user_id', $authUserId))
            ->whereHas('users', fn($q) => $q->where('user_id', $otherUserId))
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create(['type' => 'private', 'name' => $fullName]);
            $conversation->users()->attach([$authUserId, $otherUserId]);
        }

        return $this->responseSuccess('Conversation Successfully Created', $conversation->load('users'));
    }
}
