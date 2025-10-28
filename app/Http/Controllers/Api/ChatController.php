<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Events\NewConversation;
use App\Events\NewMessageOnConversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StartPrivateChatMessageRequest;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageStatus;
use Carbon\Carbon;
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

        $conversations = $user->conversations()
            ->with([
                'users',
                'messages' => function ($query) {
                    $query->latest()->limit(1)->select('id', 'conversation_id', 'sender_id', 'body', 'attachments', 'created_at');
                }
            ])
            ->get()
            ->map(function ($conversation) use ($user) {
                // Identify the other participant
                $receiver = $conversation->users->where('id', '!=', $user->id)->first();

                // Sender (current authenticated user) counts
                $senderCounts = \App\Models\MessageStatus::whereHas('message', function ($q) use ($conversation, $user) {
                    $q->where('conversation_id', $conversation->id)
                        ->where('sender_id', $user->id);
                })
                    ->selectRaw("
                    SUM(status = 'sent') as new_message,
                    SUM(status = 'received') as received_count,
                    SUM(status = 'read') as read_count
                ")
                    ->first();

                // Receiver (other participant) counts
                $receiverCounts = \App\Models\MessageStatus::whereHas('message', function ($q) use ($conversation, $receiver) {
                    $q->where('conversation_id', $conversation->id)
                        ->where('sender_id', $receiver?->id);
                })
                    ->selectRaw("
                    SUM(status = 'sent') as new_message,
                    SUM(status = 'received') as received_count,
                    SUM(status = 'read') as read_count
                ")
                    ->first();

                // Attach custom object
                $conversation->message_status = [
                    'sender' => $senderCounts,
                    'receiver' => $receiverCounts,
                ];

                return $conversation;
            });

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
            'content' => 'required_without:attachments|string|nullable',
            'attachments' => 'required_without:content|array|nullable',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480',
        ]);


        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('messages', 'public'); // store under storage/app/public/messages
                $attachments[] = [
                    'type' => str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image',
                    'url' => asset('videos/' . $path)
                ];
            }
        }

        $conversation = Conversation::with('users')->find($request->conversation_id);

        // Get the other user (exclude the authenticated user)
        $receiver = $conversation->users->firstWhere('id', '!=', Auth::id());
        $receiverId = $receiver ? $receiver->id : null;

        // Create the message
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::id(),
            'body' => $request->content,
            'attachments' => $attachments ? json_encode($attachments) : null,
        ]);

        // Save message status for sender
        MessageStatus::create([
            'message_id' => $message->id,
            'user_id' => $receiverId,
            'status' => 'sent',
        ]);



        // Get the receiver's user ID
        $conversation = $message->conversation()->with('users')->first();

        $message_count = $conversation->messages()->count();

        if ($receiver) {
            broadcast(new MessageSent($message, $receiver->id));
        }

        // Only send auto-reply if sender is NOT an admin and it's the first message
        if ($message_count == 1 && Auth::user()->role_type !== 'admin') {

            $message_for_new_conversation = Message::create([
                'conversation_id' => $request->conversation_id,
                'sender_id' => $receiverId,
                'body' => "Your Message Has been received, We will get back to you shortly.",
                'created_at' => Carbon::now()->addSeconds(1),
            ]);

            broadcast(new MessageSent($message_for_new_conversation, Auth::id()));
        }

        return $this->responseSuccess('Message Send successfully', $message);
    }

    // Optional: create new private conversation between two users
    public function startPrivateChat(StartPrivateChatMessageRequest $request)
    {
        $authUserId = auth()->id();
        $otherUserId = $request->user_id;

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

    public function update_message_status($id)
    {
        $userId = Auth::id();

        // Get the conversation
        $conversation = Conversation::with('users')->findOrFail($id);

        // Ensure the user is part of this conversation
        if (! $conversation->users->contains($userId)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find all message statuses for this conversation where the current user is the receiver and status != read
        $updated = MessageStatus::whereHas('message', function ($q) use ($conversation) {
            $q->where('conversation_id', $conversation->id);
        })
            ->where('user_id', $userId)
            ->where('status', '!=', 'read')
            ->update([
                'status' => 'read',
                'updated_at' => now(),
            ]);

        return $this->responseSuccess(
            'Message statuses updated successfully',
            ['updated_count' => $updated]
        );
    }

    public function get_conversations_counts(Request $request)
    {
        $user = Auth::user();
        $messages_count = MessageStatus::where('user_id', $user->id)
            ->where('status', 'sent')
            ->count();

        return $this->responseSuccess(
            'Message count display successfully',
            ['updated_count' => $messages_count]
        );
    }
}
