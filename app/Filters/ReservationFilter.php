<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ReservationFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        'total_downpayment_price',
        'status'
    ];

    protected array $relationSearch = [
        'customer' => ['fname', 'lname'],
        'lot' => ['lot_number']
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
        if (!is_null($status)) {
            $this->builder->where('status', $status);
        }

        return $this;
    }
}
