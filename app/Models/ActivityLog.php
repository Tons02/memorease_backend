<?php

namespace App\Models;

use App\Filters\ActivityLogFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
     use HasFactory, Filterable;
    protected $fillable = [
        'action',
        'user_id',
    ];


    protected string $default_filters = ActivityLogFilter::class;

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

}
