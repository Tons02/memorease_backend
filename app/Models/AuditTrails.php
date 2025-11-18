<?php

namespace App\Models;

use App\Filters\AuditTrailFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrails extends Model
{
    use HasFactory, Filterable;
    protected $fillable = [
        'lot_id',
        'current_owner_id',
        'previous_owner',
    ];

    protected $hidden = [
        "updated_at",
    ];

    protected $casts = [
        'previous_owner' => 'json',
    ];

    protected string $default_filters = AuditTrailFilter::class;

    
    public function current_owner()
    {
        return $this->belongsTo(User::class, 'current_owner_id')->withTrashed();
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class, 'lot_id')->withTrashed();
    }

}
