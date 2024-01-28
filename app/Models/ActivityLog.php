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
        'start_work_time',
        'end_work_time',
        'hours',
        'start_work_lat',
        'start_work_lng',
        'end_work_lat',
        'end_work_lng',
    ];
    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
