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
        'total_downpayment_price',
        'proof_of_payment',
        'remarks',
        'reserved_at',
        'expires_at',
        'paid_at',
        'approved_date',
        'approved_id',
    ];

    protected $hidden = [
        "updated_at",
    ];

    protected string $default_filters = ReservationFilter::class;

    public function lot()
    {
        return $this->belongsTo(Lot::class, 'lot_id')->withTrashed();
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function approved()
    {
        return $this->belongsTo(User::class, 'approved_id')->withTrashed();
    }
}
