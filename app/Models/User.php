<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
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

    public function publicIps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(publicIp::class,  'user_id', );
    }

    public function targets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Target::class, 'user_targets')->withPivot(['target_value', 'meeting_date', 'target_done']);
    }

    public function getISActiveAttribute()
    {
        return $this->getRawOriginal('is_active') ? __('lang.active'):__('lang.not_active');
    }

}
