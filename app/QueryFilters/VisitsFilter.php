<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class VisitsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function added_by($term)
    {
        return $this->builder->where('added_by',$term);
    }

    public function next_action($term)
    {
        return $this->builder->where('next_action',$term);
    }

    public function next_action_date($term)
    {
        return $this->builder->where('next_action_date',$term);
    }

    public function next_tasks($term)
    {
        return $this->builder->where('next_action_date', '>=',$term);
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }

    public function city_id($term)
    {
        return $this->builder->where('city_id', $term);
    }

}
