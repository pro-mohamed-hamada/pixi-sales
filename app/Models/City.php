<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class City extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'governorate_id'];

    public function governorate(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Governorate::class);
    }
}
