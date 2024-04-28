<?php

namespace App\Enum;

class FcmEventsNames
{
    public static array $EVENTS = [
        'ONE_DAY_BEFORE_MEETING'   => 'ONE_DAY_BEFORE_MEETING',
        'ONE_DAY_BEFORE_VISIT'   => 'TWO_DAY_BEFORE_VISIT',

    ];

    public static array $FCMACTIONS = [
        'CREATE_NEW_CLIENT'            => 'create_new_client',
        'REASSIGN_CLIENT' => 'reassign_client',
        'FULL_TARGET' => 'full_target',
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