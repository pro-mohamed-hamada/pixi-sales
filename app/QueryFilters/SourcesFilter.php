<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class SourcesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function title($term)
    {
        return $this->builder->where('title',$term);
    }

    public function keyword($term)
    {
        return $this->builder->where('title', 'like', '%'.$term.'%');
    }

}
