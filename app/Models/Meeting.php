<?php

namespace App\Models;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\NextActionTrait;

class Meeting extends Model
{
    use HasFactory, Filterable, NextActionTrait;

    protected $fillable = [
        'client_id',
        'date',
        'next_action',
        'next_action_date',
        'comment',
        'added_by',
        'is_done',
    ];

    public function getLatestActionTypeAttribute()
    {
        return __('lang.meeting');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getIconAttribute()
    {
        return asset('images/meeting.jpg');
    }


}
