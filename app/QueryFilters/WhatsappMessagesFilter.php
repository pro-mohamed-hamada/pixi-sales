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

}
