<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class Governorate extends Model
{
    use HasFactory, HasTranslations, Filterable;

    protected $fillable = ['name'];

    public $translatable = ['name'];

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class,  'governorate_id');
    }
}
