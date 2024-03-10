<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CallsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function client_id($term)
    {
        return $this->builder->where('client_id',$term);
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
        if (isset($term))
            return $this->builder->whereHas('client', function ($query) use ($term) {
                $query->where('name', 'like', '%'.$term.'%')
                ->where('phone', 'like', '%'.$term.'%')
                ->where('company_name', 'like', '%'.$term.'%')
                ->where('other_person_name', 'like', '%'.$term.'%')
                ->where('other_person_phone', 'like', '%'.$term.'%')
                ->where('other_person_position', 'like', '%'.$term.'%');
            });
    }

}
