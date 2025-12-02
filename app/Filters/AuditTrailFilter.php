<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class AuditTrailFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $relationSearch = [
        'lot' => ['lot_number']
    ];

    
    public function customer_id($customer_id)
    {
        if ($customer_id) {
            return $this->builder->where('current_owner_id', $customer_id);
        }

        return $this->builder;
    }

}
