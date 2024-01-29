<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Target extends Model
{
    use HasFactory, HasTranslations, Filterable;

    protected $fillable = ['name'];

    public $translatable = ['name'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_targets')->withPivot('user_targets');
    }

}
