<?php

namespace App\Imports;

use App\Enum\ActivationStatusEnum;
use App\Enum\UserTypeEnum;
use App\Models\Client;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class LiveFcmImport implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow
{

    protected array $data;

    // Add a constructor to accept the request
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('email', $row['email'])->first();
        if($user)
        {
            $title = $this->data['title'];
            $body = $this->data['content'];
            $replaced_values = [
                '@USER_NAME@'=>$user->name,
                '@USER_PHONE@'=>$user->phone,
                '@RESERVATION_NUMBER@'=>$user->client?->reservation_number,
                '@PACKAGE@'=>$user->client?->package,
                '@LAUNCH_DATE@'=>$user->client?->launch_date,
                '@GENDER@'=>$user->client?->gender,
                '@IDENTITY_NUMBER@'=>$user->client?->identity_number,
            ];
            $body = replaceFlags($body,$replaced_values);
            $tokens[0] = $user->device_token;
            app()->make(NotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
            $user->notify(new \App\Notifications\GeneralNotification(title: $title, content: $body));
        }
        
    }

    public function rules(): array
    {
        return [
            'email'=>['required', 'exists:users,email'],
        ];
    }

}
