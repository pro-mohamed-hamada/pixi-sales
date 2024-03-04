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
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }
}
