<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'status', 'reason_id', 'comment'];

    public function reason(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Reason::class);
    }
}
