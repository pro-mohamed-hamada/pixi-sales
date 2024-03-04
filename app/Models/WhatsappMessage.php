<?php

namespace App\Models;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class WhatsappMessage extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'client_id',
        'whatsapp_template_id',
        'title',
        'content',
        'phone',
        'added_by',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Client::class);
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
}
