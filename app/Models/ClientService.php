<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\NextActionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    use HasFactory, Filterable, NextActionTrait;

    protected $fillable = [
        'client_id',
        'service_id',
        'price',
        'currency',
        'comment',
        'next_action',
        'next_action_date',
        'added_by',
        'is_done',
        'person_position',
    ];

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ClientActivity::class, 'activity');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getTaskTableAttribute()
    {
        return 'client_service';
    }

}
