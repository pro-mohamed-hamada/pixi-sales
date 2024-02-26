<?php

namespace App\Traits;

use App\Abstracts\QueryFilter;
use Termwind\Components\BreakLine;

trait IsActiveTrait
{

    public function getIsActiveAttribute()
    {
        switch($this->getRawOriginal('is_active'))
        {
            case 1:
                return __('lang.active');
                break;
            case 0:
                return __('lang.not_active');
                break;
            default:
                return "";
        }
    }

}
