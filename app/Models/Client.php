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
    public function clientHistory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientHistory::class,  'client_id');
    }
    public function latestStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ClientHistory::class, 'client_id')->latestOfMany();
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientService::class,  'client_id');
    }

    public function calls(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Call::class,  'client_id');
    }

}
