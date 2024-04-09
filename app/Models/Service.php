<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;

class Service extends Model
{
    use HasFactory, Filterable, IsActiveTrait;

    protected $fillable = ['name', 'is_active'];


    public function clients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Client::class, ClientService::class)->withPivot('price', 'next_action', 'next_action_date', 'comment');
    }

}
