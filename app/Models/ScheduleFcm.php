<?php

namespace App\Models;

use App\Enum\FcmEventsNames;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;

class ScheduleFcm extends Model
{
    use HasFactory, Filterable, IsActiveTrait;

    protected $fillable = [
        'title',
        'content',
        'trigger',
        'notification_via',
        'is_active',
    ];

}
