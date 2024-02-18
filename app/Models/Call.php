<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Call extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'client_id',
        'type',
        'date',
        'comment',
        'status',
        'next_action_date',
        'next_action_note',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
