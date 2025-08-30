<?php

namespace App\Models;

use App\Filters\TermsAndAgreementFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermsAndAgreement extends Model
{

    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'terms',
    ];

    protected string $default_filters = TermsAndAgreementFilter::class;
}
