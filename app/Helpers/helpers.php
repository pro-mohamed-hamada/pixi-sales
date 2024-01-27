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


if (!function_exists('changePointsToPounds')) {

    function changePointsToPounds(float $points): float
    {
        if(!Auth::check())
            return 0;
        else{

            if(Auth::user()->center_id)

                return setting('points','center_points_per_pound') ? round($points / setting('points','center_points_per_pound'),2):0;
            else
                return setting('points','patient_points_per_pound') ? round($points / setting('points','patient_points_per_pound'),2):0;
        }
    }
}


if (!function_exists('changePoundsToPoints')) {

    function changePoundsToPoints(float $money): float
    {
        if(!Auth::check())
            return $money * setting('points','patient_points_per_pound');
        else{

            if(Auth::user()->center_id)
                return $money * setting('points','center_points_per_pound');
            else
                return $money * setting('points','patient_points_per_pound');
        }
    }
}

// if (!function_exists('changeCenterPointsToPounds')) {

//     function changeCenterPointsToPounds(float $points): float
//     {
//         return $points / setting('points','center_points_per_pound');
//     }
// }


// if (!function_exists('changeCenterPoundsToPoints')) {

//     function changeCenterPoundsToPoints(float $pounds): float
//     {
//         return $pounds * setting('points','center_points_per_pound');
//     }
// }