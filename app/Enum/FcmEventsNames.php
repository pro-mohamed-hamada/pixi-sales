<?php

namespace App\Enum;

class FcmEventsNames
{
    public static array $EVENTS = [
        'ONE_HOUR_BEFORE_TASK'   => 'ONE_HOUR_BEFORE_TASK',
        // 'HALF_HOUR_BEFORE__NOT_DONE_TASK'   => 'HALF_HOUR_BEFORE__NOT_DONE_TASK',
        'LATE_TARGET'   => 'LATE_TARGET',
        'EVERY_WEAK_TARGET'   => 'EVERY_WEAK_TARGET',
        'LESS_THAN_70_TARGET_REMEMBER'   => 'LESS_THAN_70_TARGET_REMEMBER',

    ];

    public static array $FCMACTIONS = [
        'REASSIGN_CLIENT' => 'reassign_client',
        'FULL_TARGET' => 'full_target',
        'CLIENT_NOT_REGISTER_AFTER_CALL' => 'client_not_register_after_call',
    ];

    public static array $FLAGS = [
        '@USER_NAME@'=>'@USER_NAME@',
        '@USER_EMAIL@'=>'@USER_EMAIL@',
    ];

    public static array $CHANNELS = [
        'fcm'=>'fcm',
        // 'mail'=>'mail',
    ];
}