<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;

class FcmMessage extends Model
{
    use HasFactory, Filterable, IsActiveTrait;

    public const REASSIGN_CLIENT = 'REASSIGN_CLIENT';
    public const FULL_TARGET = 'FULL_TARGET';
    public const CLIENT_NOT_REGISTER_AFTER_CALL = 'CLIENT_NOT_REGISTER_AFTER_CALL';

    protected $fillable = [
        'title',
        'content',
        'fcm_action',
        'notification_via',
        'is_active',
    ];

}
