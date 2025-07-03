<?php

namespace App\Models;

use App\Filters\DeceasedFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deceased extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'deceased';

    protected $fillable = [
        'lot_image',
        'lot_id',
        'fname',
        'mname',
        'lname',
        'suffix',
        'gender',
        'birthday',
        'burial_date',
        'death_date',
        'death_certificate',
    ];

    protected $hidden = [
        "updated_at",
    ];

    protected string $default_filters = DeceasedFilter::class;

    public function lot()
    {
        return $this->belongsTo(Lot::class, 'lot_id')->withTrashed();
    }
}
