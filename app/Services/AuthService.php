<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\NotFoundException;
use App\Enum\UserTypeEnum;
use App\QueryFilters\ClientsFilter;
use Carbon\Carbon;

class AuthService extends BaseService
{

    public function loginWithEmail(string $email, string $password, string $deviceSerial, bool $remember = false) :User|Model
    {
        $credential = ['email'=>$email,'password'=>$password, 'type'=>[UserTypeEnum::MANAGER, UserTypeEnum::EMPLOYEE]];
        if (!auth()->attempt(credentials: $credential, remember: $remember))
            return throw new NotFoundException(__('lang.login_failed'));
        $user = User::where('email', $email)->first();
        // $userDeviceSerial = $user->deviceSerials()->where('device_serial', $deviceSerial)->first();
        // if(!$userDeviceSerial)
        //     return throw new NotFoundException(__('lang.unauthorized_device'));
        return $user;
    }


    public function startWork($startWorkLat, $startWorklng) :bool
    {
        $user = auth::user();
        $status = $user->activityLogs()->create([
            'start_work_time'=> Carbon::now()->setTimezone('Africa/Cairo'),
            'start_work_lat'=>$startWorkLat,
            'start_work_lng'=>$startWorklng,
        ]);
        if(!$status)
            return false;
        return true;
        
    }
    public function endWork($endWorkLat, $endWorklng) :bool
    {
        $user = auth::user();
        $latestActivityLog = $user->activityLogs->last();
        $startWorkTime = $latestActivityLog->start_work_time;
        $endWorkTime = Carbon::now()->setTimezone('Africa/Cairo');
        $status = $latestActivityLog->update([
            'end_work_time'=> $endWorkTime,
            'hours'=>$endWorkTime->floatDiffInHours($startWorkTime),
            'end_work_lat'=>$endWorkLat,
            'end_work_lng'=>$endWorklng,
        ]);
        if(!$status)
            return false;
        return true;
        
    }

    public function userTarget() //:User|Model|bool
    {
        $user = auth::user();
        if(!$user)
            return false;
        return $user->load('targets')->where('created_at', '>=', Carbon::now()->subMonth());
    }

    public function updateProfileLogo(array $data)
    {
        $user = Auth::user();
        if (isset($data['logo']))
        {
            $user->clearMediaCollection('users');
            $user->addMediaFromRequest('logo')->toMediaCollection('users');
        }
        return $user;

    }

    public function logout(): bool
    {
        $user =  auth::user();
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
        }
        return $user;

    }
    public function setUserFcmToken(User $user , $fcm_token)
    {
        if (isset($fcm_token))
            $user->update(['device_token'=>$fcm_token]);
    }
}
