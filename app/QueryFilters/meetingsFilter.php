<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class MeetingsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function client_id($term)
    {
        return $this->builder->where('client_id',$term);
    }

    public function date($term)
    {
        return $this->builder->where('date',$term);
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

}
