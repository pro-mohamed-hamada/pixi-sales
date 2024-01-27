<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class ActivityLog extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id'=>2,
            'login_time',
            'logout_time',
            'hours',
            'login_lat',
            'login_lng',
            'logout_lat',
            'logout_lng',
    ];
    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
