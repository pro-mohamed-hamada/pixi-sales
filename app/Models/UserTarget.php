<?php

namespace App\Models;

use App\Enum\TargetsEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTarget extends Model
{
    use HasFactory;

    protected $fillable = ['target', 'user_id', 'target_value', 'target_done'];

    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTargetAttribute()
    {
        switch($this->getRawOriginal('target'))
        {
            case TargetsEnum::CALL:
                return __('lang.calls');
                break;
            case TargetsEnum::CLIENT:
                return __('lang.clients');
                break;
            case TargetsEnum::MEETING:
                return __('lang.meetings');
                break;
            case TargetsEnum::PROPOSAL:
                return __('lang.proposals');
                break;
            case TargetsEnum::VISIT:
                return __('lang.visits');
                break;
            case TargetsEnum::WHATSAPP_MESSAGE:
                return __('lang.whatsapp_messages');
                break;
            default:
                return "";
        }
    }
}
