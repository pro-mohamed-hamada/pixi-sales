<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTarget extends Model
{
    use HasFactory;

    protected $fillable = ['target_id', 'user_id', 'target_value', 'meeting_date', 'target_done'];

    public function target(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Target::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
