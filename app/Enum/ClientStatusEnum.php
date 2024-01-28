<?php

namespace App\Enum;

class ClientStatusEnum
{
    const NEW = 1;
    const CONTACTED_INCOMING = 2;
    const CONTACTED_OUTGOING = 3;
    const INTERESTED = 4;
    const NOT_INTERESTED = 5;
    const PROPOSAL = 6;
    const MEETING = 7;
    const CLOSED = 8;
    const LOST = 9;
}
