<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Country extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'slug', 'code', 'is_active'];

    public function governorates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Governorate::class,  'country_id');
    }
}
