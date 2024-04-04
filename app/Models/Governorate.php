<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Governorate extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'country_id'];

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class,  'governorate_id');
    }
}
