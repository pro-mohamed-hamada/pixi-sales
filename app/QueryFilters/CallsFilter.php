<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CallsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function type($term)
    {
        return $this->builder->where('type',$term);
    }

    public function status($term)
    {
        return $this->builder->where('status',$term);
    }

    public function date($term)
    {
        return $this->builder->where('date',$term);
    }

    public function next_action_date($term)
    {
        return $this->builder->where('next_action_date',$term);
    }

}
