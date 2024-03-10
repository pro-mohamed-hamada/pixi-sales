<?php

namespace App\Enum;

class WhatsappEventsNames
{
    public static array $WHATSAPP_TEMPLATES_FLAGS = [
        '@USER_NAME@'=>'@USER_NAME@',
        '@MEETING_DATE@'=>'@MEETING_DATE@',
        '@CALL_DATE@'=>'@CALL_DATE@',
        '@NEXT_ACTION_DATE@'=>'@NEXT_ACTION_DATE@',
    ];

    public static array $ACTIONS = [
        'NEW'=>'new',
        'CONTACTED'=>'contacted',
        'INTERESTED'=>'interested',
        'NOT_INTERESTED'=>'not_interested',
        'PROPOSAL'=>'proposal',
        'MEETING'=>'meeting',
        'CLOSED'=>'closed',
        'LOST'=>'lost',
        'CALL'=>'call',
        'MEETING'=>'meeting',
        'VISIT'=>'visit',
        'SERVICE'=>'serivce',
    ];
}