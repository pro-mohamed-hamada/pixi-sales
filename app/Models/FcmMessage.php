<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;

class FcmMessage extends Model
{
    use HasFactory, Filterable, IsActiveTrait;

    public const CREAET_NEW_COMPLAINT            = 'CREAET_NEW_COMPLAINT';
    public const SUPERVISOR_REPLIED_ON_COMPLAINT = 'SUPERVISOR_REPLIED_ON_COMPLAINT';
    public const CLIENT_LOGIN = 'CLIENT_LOGIN';

    protected $fillable = [
        'title',
        'content',
        'fcm_action',
        'notification_via',
        'is_active',
    ];

}
