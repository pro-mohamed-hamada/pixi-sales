<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class City extends Model
{
    use HasFactory, HasTranslations, Filterable;

    protected $fillable = ['name', 'governorate_id'];
    public $translatable = ['name'];

    public function governorate(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Governorate::class);
    }
}
