<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\FcmEventsNames;
use App\Enum\TargetsEnum;
use App\Enum\UserTypeEnum;
use App\Http\Resources\RecentActivitiesResource;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, InteractsWithMedia, HasFactory, Notifiable, Filterable, EscapeUnicodeJson, IsActiveTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getToken(): string
    {
        return $this->createToken(config('app.name'))->plainTextToken;
    }
    public function getId()
    {
        return $this->id;
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function activityLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ActivityLog::class,  'user_id', );
    }
    
    public function latestStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ActivityLog::class, 'user_id')->latestOfMany();
    }

    public function deviceSerials(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DeviceSerial::class,  'user_id', );
    }

    public function targets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserTarget::class, 'user_id');
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class, 'added_by');
    }

    public function calls(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Call::class, 'added_by');
    }

    public function meetings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Meeting::class, 'added_by');
    }

    public function addedByClients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class, 'added_by');
    }

    public function assignedClients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class, 'assigned_to');
    }

    public function whatsappMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WhatsappMessage::class, 'added_by');
    }

    public function clientServices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientService::class, 'added_by');
    }

    public function increaseUserTarget(string $target, $clientServicesTotalPrice = 0)
    {
        if($this->getRawOriginal('type') == UserTypeEnum::EMPLOYEE)
        {
            $target = $this->targets()->where('created_at', '>=', Carbon::now()->subMonth())->where('target', $target)->first();
            if($target)
            {
                if($target->getRawOriginal('target') == TargetsEnum::AMOUNT)
                {
                    $target->target_done = $target->target_done + $clientServicesTotalPrice;
                    $target->save();
                }else{
                    $target->target_done = $target->target_done + 1;
                    $target->save();
                }
            }
        }
        
    }

    public function decreaseUserTarget(string $target)
    {

        $target = $this->targets()->where('created_at', '>=', Carbon::now()->subMonth())->where('target', $target)->first();
        if($target)
        {
            $target->target_done = $target->target_done - 1;
            $target->save();
        }
    }

    public function getRecentActivities()
    {
        $visits = $this->visits()->select('id', DB::raw("'visit' as action_type"), 'comment', 'city_id', 'created_at')->with(['city' => function($query) {
            $query->select('id', 'name');
        }])->latest()->take(5)->get();
        $meetings = $this->meetings()->select('id', DB::raw("'meeting' as action_type"), 'comment', 'created_at')->latest()->take(5)->get();
        $calls = $this->calls()->select('id', DB::raw("'call' as action_type"), 'comment', 'status', 'created_at')->latest()->take(5)->get();
        $whatsapp_messages = $this->whatsappMessages()->select('id', DB::raw("'whatsapp_message' as action_type"), 'created_at')->latest()->take(5)->get();
        $clients = $this->addedByClients()->select('id', DB::raw("'client' as action_type"), 'company_name', 'created_at')->latest()->take(5)->get();

        $data = collect($visits)
                    ->merge($meetings)
                    ->merge($calls)
                    ->merge($whatsapp_messages)
                    ->merge($clients)
                    ->sortByDesc('created_at')
                    ->take(5)
                    ->values() // Reset the keys to ensure a 0-indexed array
                    ->all(); 
        return RecentActivitiesResource::collection($data);

    }

    public function getTypeAttribute()
    {
        switch($this->getRawOriginal('type'))
        {
            case UserTypeEnum::SUPERADMIN:
                return __('lang.superadmin');
                break;
            case UserTypeEnum::MANAGER:
                return __('lang.manager');
                break;
            case UserTypeEnum::EMPLOYEE:
                return __('lang.employee');
                break;
            default:
                return "";
        }
    }

    public static function SendNotification(ScheduleFcm|FcmMessage $fcm, $users)
    {

        //prepare data
        $title = $fcm->title ;
        $body = $fcm->content ;
        foreach($users as $user)
        {
            $replaced_values = [
                '@USER_NAME@'=>$user->name,
                '@USER_EMAIL@'=>$user->email,
            ];
            $body = replaceFlags($body,$replaced_values);
            $tokens[0] = $user->device_token;

            // check the notification channel
            if($fcm->notification_via == FcmEventsNames::$CHANNELS['fcm'])
                app()->make(NotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
            else
                $user->notify(new \App\Notifications\AlraqiahEmail(title: $title, content: $body));
            
            $user->notify(new \App\Notifications\GeneralNotification(title: $title, content: $body));

        }

    }
}
