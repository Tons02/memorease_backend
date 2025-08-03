<?php

use App\Events\LotReserved;
use App\Models\Conversation;
use App\Models\Lot;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;


Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    if (!$user) {
        return false; // Not logged in
    }

    return true; // Logged in user
});

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('receiver.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::routes(['middleware' => ['auth:sanctum']]);
