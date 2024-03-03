<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class Source extends Model
{
    use HasFactory, HasTranslations, Filterable;

    protected $fillable = ['title'];

    public $translatable = ['title'];
}
