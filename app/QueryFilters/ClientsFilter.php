<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use Carbon\Carbon;

class ClientsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function phone($term)
    {
        return $this->builder->where('phone', $term);
    }

    public function other_person_phone($term)
    {
        return $this->builder->where('other_person_phone', $term);
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

    public function status($term)
    {
        return $this->builder->whereHas('latestStatus', function ($query) use ($term) {
            $query->where('status', $term);
        });
    }

    public function next_action($term)
    {
        return $this->builder->whereHas('visits', function ($query) use ($term) {
            $query->where('next_action', $term)
            ->whereDate('next_action_date', '>=', Carbon::now()->format('Y-m-d'));
        })->orWhereHas('calls', function ($query) use ($term) {
            $query->where('next_action', $term)
            ->whereDate('next_action_date', '>=', Carbon::now()->format('Y-m-d'));
        })->orWhereHas('meetings', function ($query) use ($term) {
            $query->where('next_action', $term)
            ->whereDate('next_action_date', '>=', Carbon::now()->format('Y-m-d'));
        })->orWhereHas('services', function ($query) use ($term) {
            $query->where('client_services.next_action', $term)
            ->whereDate('client_servicesnext_action_date', '>=', Carbon::now()->format('Y-m-d'));
        });
    }

    public function next_action_date($term)
    {
        return $this->builder->whereHas('visits', function ($query) use ($term) {
            $query->whereDate('next_action_date', Carbon::parse($term)->format('Y-m-d'));
        })->orWhereHas('calls', function ($query) use ($term) {
            $query->whereDate('next_action_date', Carbon::parse($term)->format('Y-m-d'));
        })->orWhereHas('meetings', function ($query) use ($term) {
            $query->whereDate('next_action_date', Carbon::parse($term)->format('Y-m-d'));
        })->orWhereHas('services', function ($query) use ($term) {
            $query->whereDate('client_services.next_action_date', Carbon::parse($term)->format('Y-m-d'));
        });
    }

    public function city_id($term)
    {
        return $this->builder->where('city_id', $term);
    }

    public function added_by($term)
    {
        return $this->builder->where('added_by', $term);
    }

    public function assigned_to($term)
    {
        return $this->builder->where('assigned_to', $term);
    }

    public function created_at($term)
    {
        return $this->builder->whereDate('created_at', Carbon::parse($term)->format('Y-m-d'));
    }

    public function source_id($term)
    {
        return $this->builder->where('source_id', $term);
    }

}
