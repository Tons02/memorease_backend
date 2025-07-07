<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class LotFilter extends QueryFilters
{
    protected array $columnSearch = [
        'lot_number'
    ];

    public function lot_status($lot_status)
    {
        if (!is_null($lot_status)) {
            $this->builder->where('status', $lot_status);
        }

        return $this;
    }
}
