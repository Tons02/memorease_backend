<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Events\NewConversation;
use App\Events\NewMessageOnConversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StartPrivateChatMessageRequest;
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
        $conversations = $user->conversations()->with([
            'users',
            'messages' => function ($query) {
                $query->latest()->limit(1); // Get last message
            }
        ])->get();

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

        // Get the receiver's user ID
        $conversation = $message->conversation()->with('users')->first();
        $receiver = $conversation->users->firstWhere('id', '!=', Auth::id());

        if ($receiver) {
            broadcast(new MessageSent($message, $receiver->id));
        }

        // event(new NewMessageOnConversation($message));

        return $this->responseSuccess('Message Send successfully', $message);
    }

    // Optional: create new private conversation between two users
    public function startPrivateChat(StartPrivateChatMessageRequest $request)
    {
        $authUserId = auth()->id();
        $otherUserId = $request->user_id; //i want the reciever to get the full name and set it the name instead of the creater

        $conversation = Conversation::where('type', 'private')
            ->whereHas('users', fn($q) => $q->where('user_id', $authUserId))
            ->whereHas('users', fn($q) => $q->where('user_id', $otherUserId))
            ->withCount('users')
            ->first();

        if ($conversation && $conversation->users_count === 2) {
            return $this->responseBadRequest(
                'A conversation with this user already exists.',
                ''
            );
        }

        $user = auth('sanctum')->user();

        $fullName = trim(
            "{$user->fname} " .
            ($user->mi ? "{$user->mi}. " : "") .
            "{$user->lname} " .
            ($user->suffix ? "{$user->suffix}" : "")
        );

        $conversation = Conversation::create([
            'type' => 'private',
            'name' => $fullName,
        ]);

        $conversation->users()->attach([$authUserId, $otherUserId]);
        NewConversation::dispatch($conversation, $otherUserId);
        return $this->responseCreated('Conversation Successfully Created', $conversation->load('users'));
    }
}
