<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class GovernoratesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function country_id($term)
    {
        return $this->builder->where('country_id', $term);
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }
    
}
