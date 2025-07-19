<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ReservationFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        'price',
        'remarks'
    ];

    public function customer_id($customer_id)
    {
        if ($customer_id) {
            return $this->builder->where('user_id', $customer_id);
        }

        return $this->builder;
    }


    public function status($status)
    {
        return $this->builder->where('status', $status);
    }
}
