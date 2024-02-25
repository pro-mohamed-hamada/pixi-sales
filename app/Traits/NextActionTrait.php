<?php

namespace App\Traits;

use App\Abstracts\QueryFilter;

trait NextActionTrait
{

    public function getNextActionAttribute()
    {
        switch($this->getRawOriginal('next_action'))
        {
            case 1:
                return __('lang.call');
                break;
            case 2:
                return __('lang.meeting');
                break;
            case 3:
                return __('lang.whatsapp');
                break;
            case 4:
                return __('lang.visit');
                break;
            default:
                return "";
        }
    }

}
