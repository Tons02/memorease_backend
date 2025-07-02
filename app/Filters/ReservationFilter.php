<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ReservationFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [];
}
