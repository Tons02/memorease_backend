<?php

namespace App\Models;

use App\Filters\LotFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lot extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'lot_image',
        'second_lot_image',
        'third_lot_image',
        'fourth_lot_image',
        'lot_number',
        'description',
        'coordinates',
        'status',
        'reserved_until',
        'price',
        'promo_price',
        'downpayment_price',
        'promo_until',
        'is_featured',
        'is_land_mark',
    ];

    protected $hidden = [
        "updated_at",
    ];

    protected string $default_filters = LotFilter::class;

    protected $casts = [
        'coordinates' => 'json',
        'is_featured' => 'boolean',
        // 'is_land_mark' => 'boolean'
    ];

    public function deceased()
    {
        return $this->hasOne(Deceased::class, 'lot_id'); // assuming 1 deceased per lot
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'lot_id');
    }
}
