<?php

use App\Events\LotReserved;
use App\Models\Lot;
use Illuminate\Support\Facades\Broadcast;

Route::get('/test-reserve-broadcast', function () {
    $lot = Lot::first(); // pick a sample lot

    broadcast(new LotReserved($lot));

    return 'Event broadcasted';
});