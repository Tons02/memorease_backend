<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class UserFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        'fname',
        'mi',
        'lname',
        'email',
        'username'
    ];


    public function role_type($role_type)
    {
        if ($role_type) {
            return $this->builder->where('role_type', $role_type);
        }

        return $this->builder;
    }
}
