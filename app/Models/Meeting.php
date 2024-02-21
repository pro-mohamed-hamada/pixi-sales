<?php

namespace App\Models;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Meeting extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'client_id',
        'date',
        'comment',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
