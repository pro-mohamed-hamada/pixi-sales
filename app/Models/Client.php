<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Client extends Model
{
    use HasFactory, Filterable;



    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function other_person_city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class, 'other_person_city_id');
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class,  'client_id');
    }
}
