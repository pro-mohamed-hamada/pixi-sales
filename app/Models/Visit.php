<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\NextActionTrait;

class Visit extends Model
{
    use HasFactory, Filterable, NextActionTrait;

    protected $fillable = [
        'client_id', 
        'date',
        'city_id',
        'next_action',
        'next_action_date',
        'comment',
        'added_by',
        'is_done',
        'person_position',
    ];

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ClientActivity::class, 'activity');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getTaskTableAttribute()
    {
        return 'visit';
    }

    public function getLatestActionTypeAttribute()
    {
        return __('lang.visit');
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getIconAttribute()
    {
        return asset('targets/visits.jpeg');
    }

}
