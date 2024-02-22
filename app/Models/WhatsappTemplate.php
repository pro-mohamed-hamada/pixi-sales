<?php

namespace App\Models;

use App\Enum\ClientStatusEnum;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappTemplate extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'title',
        'content',
        'client_status',
        'comment',
        'is_active',
    ];

    public function getClientStatusAttribute()
    {
        switch($this->getRawOriginal('client_status'))
        {
            case ClientStatusEnum::NEW:
                return __('lang.new');
                break;
            case ClientStatusEnum::INTERESTED:
                return __('lang.interested');
                break;
            case ClientStatusEnum::NOT_INTERESTED:
                return __('lang.not_interested');
                break;
            case ClientStatusEnum::CONTACTED_INCOMING:
                return __('lang.contacted_incoming');
                break;
            case ClientStatusEnum::CONTACTED_OUTGOING:
                return __('lang.contacted_outgoing');
                break;
            case ClientStatusEnum::MEETING:
                return __('lang.meeting');
                break;
            case ClientStatusEnum::PROPOSAL:
                return __('lang.proposal');
                break;
            case ClientStatusEnum::CLOSED:
                return __('lang.closed');
                break;
            case ClientStatusEnum::LOST:
                return __('lang.lost');
                break;
            default:
                return "";
        }
    }
}
