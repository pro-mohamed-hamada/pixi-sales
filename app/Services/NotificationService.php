<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
class NotificationService extends BaseService
{
    public function getUserNotifications()
    {
        $user = auth()->user();
        return $user->notifications()->get();
    }

    public function markAsRead($id): void
    {
        $user = auth()->user();
        $user->notifications->where('id', $id)->markAsRead();
    }
    
    public function notificationCount($user_id)
    {
        $user =  auth()->user();
        return $user->notifications()->count();
    }

    // public function getUser($user_id)
    // {
    //     $user = User::find($user_id);
    //     if (!$user)
    //         throw new NotFoundException(trans('user_not_found'));
    //     return $user ;
    // }

    public function destroy($id): void
    {
        $user = auth()->user();
        $user->notifications()->where('id', $id)->delete();
    }


    public function sendToTokens(string $title, string $body,$tokens = [],$data = [])
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

// return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

// return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }
}
