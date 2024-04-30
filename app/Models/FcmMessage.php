<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;

class FcmMessage extends Model
{
    use HasFactory, Filterable, IsActiveTrait;

    public const CREATE_NEW_CLIENT            = 'CREATE_NEW_CLIENT';
    public const REASSIGN_CLIENT = 'REASSIGN_CLIENT';
    public const FULL_TARGET = 'FULL_TARGET';

    protected $fillable = [
        'title',
        'content',
        'fcm_action',
        'notification_via',
        'is_active',
    ];

}
