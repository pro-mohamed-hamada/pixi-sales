<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class WhatsappTemplatesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function client_status($term)
    {
        return $this->builder->where('client_status',$term);
    }
}
