<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class DeceasedFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        'fname',
        'mname',
        'lname',
        'death_date'
    ];

    public function is_private($is_private)
    {
        if (!is_null($is_private)) {
            $this->builder->where('is_private', $is_private);
        }

        return $this;
    }
}
