<?php

namespace App\Models;

use App\Filters\ReservationFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'status',
        'lot_id',
        'user_id',
        'reserved_at',
        'expires_at',
        'reserved_at',
        'expires_at',
    ];

    protected $hidden = [
        "updated_at",
    ];

    protected string $default_filters = ReservationFilter::class;

    protected $casts = [
        'access_permission' => 'json',
    ];
}
