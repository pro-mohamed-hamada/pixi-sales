<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\NotFoundException;
use App\Enum\UserTypeEnum;
use App\Models\ActivityLog;
use Carbon\Carbon;

class AuthService extends BaseService
{

    public function loginWithEmail(string $email, string $password, string $loginLat, $loginLng, bool $remember = false) :User|Model
    {
        $credential = ['email'=>$email,'password'=>$password, 'type'=>UserTypeEnum::EMPLOYEE];
        if (!auth()->attempt(credentials: $credential, remember: $remember))
            return throw new NotFoundException(__('lang.login_failed'));
        $user = User::where('email', $email)->first();
        $user->activityLogs()->create([
            'login_time'=> Carbon::now()->setTimezone('Africa/Cairo'),
            'login_lat'=>$loginLat,
            'login_lng'=>$loginLng,
        ]);
        return $user;
    }

    public function logout(string $logoutLat, $logoutLng): bool
    {
        $user =  auth::user();
        $lastActivityLog = $user->activityLogs->last();
        $loginTime = $lastActivityLog->login_time;
        $logoutTime = Carbon::now()->setTimezone('Africa/Cairo');
        $lastActivityLog->update([
            'logout_time'=> $logoutTime,
            'hours'=> $logoutTime->floatDiffInHours($loginTime),
            'logout_lat'=>$logoutLat,
            'logout_lng'=>$logoutLng,
        ]);
        Auth::user()->tokens()->delete();
        return true;
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data=[]): mixed
    {
        $user = User::create($data);
        ResetCodePassword::sendCode(phone: $data['phone']);
        return $user;
    }

    public function getAuthUser()
    {
        return auth('sanctum')->user();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function updateLogo(array $data)
    {
        $user = Auth::user();
        if (isset($data['logo'])) {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'], path: 'uploads/users', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        return $user;

    }
    public function setUserFcmToken(User $user , $fcm_token)
    {
        if (isset($fcm_token))
            $user->update(['device_token'=>$fcm_token]);
    }
}
