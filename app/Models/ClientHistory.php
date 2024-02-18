<?php

namespace App\Models;

use App\Enum\ClientStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'status', 'reason_id', 'comment', 'date_time'];

    public function reason(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Reason::class);
    }

    public function getStatusAttribute()
    {
        switch($this->getRawOriginal('status'))
        {
            case ClientStatusEnum::NEW:
                return __('lang.new');
                break;
            case ClientStatusEnum::CONTACTED_INCOMING:
                return __('lang.contacted_incoming');
                break;
            case ClientStatusEnum::CONTACTED_OUTGOING:
                return __('lang.contacted_outcoming');
                break;
            case ClientStatusEnum::INTERESTED:
                return __('lang.interested');
                break;
            case ClientStatusEnum::NOT_INTERESTED:
                return __('lang.not_interested');
                break;
            case ClientStatusEnum::PROPOSAL:
                return __('lang.proposal');
                break;
            case ClientStatusEnum::MEETING:
                return __('lang.meeting');
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
