<?php

namespace App\Models;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\NextActionTrait;

class Call extends Model
{
    use HasFactory, Filterable, NextActionTrait;

    protected $fillable = [
        'client_id',
        'type',
        'date',
        'comment',
        'status',
        'next_action',
        'next_action_date',
        'added_by',
        'is_done',
    ];

    public function activities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ClientActivity::class, 'activity');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getLatestActionTypeAttribute()
    {
        return __('lang.call');
    }

    public function getTaskTableAttribute()
    {
        return 'call';
    }

    public function getTypeAttribute()
    {
        switch($this->getRawOriginal('type'))
        {
            case CallTypeEnum::INCOMING:
                return __('lang.incoming');
                break;
            case CallTypeEnum::OUTGOING:
                return __('lang.outgoing');
                break;
            default:
                return null;

        }
    }

    public function getStatusAttribute()
    {
        switch($this->getRawOriginal('status'))
        {
            case CallStatusEnum::ANSWERED:
                return __('lang.answered');
                break;
            case CallStatusEnum::NOT_ANSWERED:
                return __('lang.not_answered');
                break;
            case CallStatusEnum::NOT_AVAILABLE:
                return __('lang.not_available');
                break;
            case CallStatusEnum::PHONE_CLOSED:
                return __('lang.phone_closed');
                break;
            case CallStatusEnum::ERROR_NUMBER:
                return __('lang.error_number');
                break;
            default:
                return null;

        }
    }
    public function getIconAttribute()
    {
        return asset('images/call.jpg');
    }
        
}
