<?php

namespace App\Models;

use App\Filters\CemeteriesFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cemeteries extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'profile_picture',
        'name',
        'description',
        'location',
    ];

    protected $hidden = [
        "updated_at",
    ];

    protected string $default_filters = CemeteriesFilter::class;
}
