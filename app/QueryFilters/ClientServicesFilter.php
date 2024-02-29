<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class ClientServicesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }
    
    public function client_id($term)
    {
        return $this->builder->where('client_id',$term);
    }

}
