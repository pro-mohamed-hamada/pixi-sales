<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class ClientsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function phone($term)
    {
        return $this->builder->where('phone', $term);
    }

    public function other_person_phone($term)
    {
        return $this->builder->where('phone', $term);
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%')
        ->orWhere('phone', 'like', '%'.$term.'%')
        ->orWhere('company_name', 'like', '%'.$term.'%')
        ->orWhere('other_person_name', 'like', '%'.$term.'%')
        ->orWhere('other_person_phone', 'like', '%'.$term.'%')
        ->orWhere('other_person_position', 'like', '%'.$term.'%');    }
    
    public function governorate_id($term)
    {
        if (isset($term))
            return $this->builder->whereHas('city', function ($query) use ($term) {
                $query->where('governorate_id', $term);
            });
    }

    public function city_id($term)
    {
        return $this->builder->where('city_id', $term);
    }

}
