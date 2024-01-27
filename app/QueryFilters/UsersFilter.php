<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use Illuminate\Support\Arr;
class UsersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }

    public function type($term)
    {
        return $this->builder->where('type',$term);
    }
    
    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function phone($term)
    {
        return $this->builder->where('phone',$term);
    }

    public function email($term)
    {
        return $this->builder->where('email',$term);
    }

}
