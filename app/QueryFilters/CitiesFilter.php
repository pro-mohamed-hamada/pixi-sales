<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CitiesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function title($term)
    {
        return $this->builder->where('name',$term);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id',$term);
    }

    public function governorate_id($term)
    {
        return $this->builder->where('governorate_id', $term);
    }

    public function age($term)
    {
        return $this->builder->where('age', $term);
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }
    
}
