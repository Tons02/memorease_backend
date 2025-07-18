<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class DeceasedFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        'first_name'
    ];
}
