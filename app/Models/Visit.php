<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Visit extends Model
{
    use HasFactory, Filterable;



    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
