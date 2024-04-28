<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class ScheduleFcmFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }

}
