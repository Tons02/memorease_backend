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


Broadcast::routes(['middleware' => ['auth:sanctum']]);
