<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class LotFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [];
}
