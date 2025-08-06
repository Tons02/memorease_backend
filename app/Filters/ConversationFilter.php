<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ConversationFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [];
}
