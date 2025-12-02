<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ActivityLogFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        'action'
    ];

    public function user_id($user_id)
    {
        if ($user_id) {
            return $this->builder->where('user_id', $user_id);
        }
        
        return $this->builder;
    }
}
