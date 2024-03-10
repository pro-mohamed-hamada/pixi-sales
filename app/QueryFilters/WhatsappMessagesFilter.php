<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class WhatsappMessagesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function client_id($term)
    {
        return $this->builder->where('client_id',$term);
    }

    public function template_id($term)
    {
        return $this->builder->where('template_id',$term);
    }

    public function created_at($term)
    {
        return $this->builder->where('created_at',$term);
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
