<?php

namespace App\Models;

use App\Enum\ClientActivityActionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'activity_type',
        'activity_id',
        'action',
    ];

    public function activity(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function getActionAttribute(){
        switch($this->getRawOriginal('action'))
        {
            case ClientActivityActionEnum::ADDED:
                return __('lang.added');
                break;
            case ClientActivityActionEnum::UPDATED:
                return __('lang.updated');
                break;
            default:
                return "";
        }
    }
    public function getActivityTypeAttribute(){
        switch($this->getRawOriginal('activity_type'))
        {
            case "App\Models\Call":
                return __('lang.call');
                break;
            case "App\Models\Visit":
                return __('lang.visit');
                break;
            case "App\Models\Meeting":
                return __('lang.meeting');
                break;
            case "App\Models\ClientService":
                return __('lang.service');
                break;
            case "App\Models\WhatsappMessage":
                return __('lang.whatsapp_message');
                break;
            default:
                return "";
        }
    }

}
