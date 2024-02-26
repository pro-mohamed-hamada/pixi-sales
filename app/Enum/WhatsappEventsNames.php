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

    const NEW = 1;
    const CONTACTED_INCOMING = 2;
    const INTERESTED = 4;
    const NOT_INTERESTED = 5;
    const PROPOSAL = 6;
    const MEETING = 7;
    const CLOSED = 8;
    const LOST = 9;
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
    ];
}