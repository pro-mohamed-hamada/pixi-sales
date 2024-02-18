<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
class Service extends Model
{
    use HasFactory, HasTranslations, Filterable;

    protected $fillable = ['name', 'is_active'];

    public $translatable = ['name'];

    public function getISActiveAttribute()
    {
        return $this->getRawOriginal('is_active') ? __('lang.active'):__('lang.not_active');
    }
}
