<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Resources\RecentActivitiesResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, EscapeUnicodeJson;

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

    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class, 'added_by');
    }

    public function whatsappMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WhatsappMessage::class, 'added_by');
    }

    public function clientServices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientService::class, 'added_by');
    }

    public function getISActiveAttribute()
    {
        return $this->getRawOriginal('is_active') ? __('lang.active'):__('lang.not_active');
    }

    public function increaseUserTarget(string $target)
    {
        $target = $this->targets()->where('target', $target)->first();
        if($target)
        {
            $target->target_done = $target->target_done + 1;
            $target->save();
        }
    }

    public function decreaseUserTarget(string $target)
    {

        $target = $this->targets()->where('target', $target)->first();
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
        $clients = $this->clients()->select('id', DB::raw("'client' as action_type"), 'company_name', 'created_at')->latest()->take(5)->get();

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
}
