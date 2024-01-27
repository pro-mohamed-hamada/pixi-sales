<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Client extends Model
{
    use HasFactory, Filterable;


    protected $fillable = ['name', 'phone', 'industry', 'company_name', 'city_id', 'other_person_name', 'other_person_phone', 'other_person_position'];

    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class,  'client_id');
    }
}
