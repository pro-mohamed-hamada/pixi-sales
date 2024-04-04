<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

if (!function_exists('apiResponse')) {
    function apiResponse($data = null, $message = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'status' => in_array($code, successCode()),
            'message' => $message,
        ];
        return response($array, $code);
    }
}

if (!function_exists('successCode')) {
    function successCode(): array
    {
        return [
            200, 201, 202
        ];
    }
}

if (!function_exists('getDateOfSpecificDay')) {

    function getDateOfSpecificDay($day, $date): \Carbon\Carbon
    {
        $dayOfWeek = $date->dayOfWeek;

        if ($dayOfWeek != (int)$day) {
            $date = $date->addDay();
            $date = getDateOfSpecificDay($day, $date);
        }
        return $date;
    }
}


if (!function_exists('getLocale')) {

    function getLocale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('formatPhone')) {

    function formatPhone(string $phone, string $slug): string
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $swissNumberProto = $phoneUtil->parse($phone, $slug);
        return $phoneUtil->format($swissNumberProto, \libphonenumber\PhoneNumberFormat::E164);
    }
}

if (!function_exists('userCan')) {

    function userCan(Request $request, string $permission)
    {
        if(!$request->user()->can($permission))
            abort(403);
    }
}


if (!function_exists('setLanguage')) {

    function setLanguage(string $locale): void
    {
        app()->setLocale($locale);
    }
}

if (!function_exists('replaceFlags')) {

    function replaceFlags($content,$values =[])
    {
        if (count($values)){
            foreach (\App\Enum\WhatsappEventsNames::$WHATSAPP_TEMPLATES_FLAGS as $FLAG)
            {
                if (isset($values[$FLAG]))
                    $content = str_replace($FLAG,$values[$FLAG],$content);
            }
        }
        return $content;

    }
}