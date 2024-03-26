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
        'comment',
        'next_action',
        'next_action_date',
        'added_by',
        'is_done',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getTaskTableAttribute()
    {
        return 'client_service';
    }

}
