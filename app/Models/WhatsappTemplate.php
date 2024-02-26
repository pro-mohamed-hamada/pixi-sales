<?php

namespace App\Models;

use App\Enum\ClientStatusEnum;
use App\Traits\Filterable;
use App\Traits\IsActiveTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappTemplate extends Model
{
    use HasFactory, Filterable, IsActiveTrait;

    protected $fillable = [
        'title',
        'content',
        'action',
        'comment',
        'is_active',
    ];
}
