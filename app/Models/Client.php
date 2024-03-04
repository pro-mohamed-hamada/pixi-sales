<?php

namespace App\Models;

use App\Enum\ClientStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Exception;

class Client extends Model
{
    use HasFactory, Filterable;


    protected $fillable = [
        'name',
        'phone',
        'industry',
        'company_name',
        'city_id',
        'other_person_name',
        'other_person_phone',
        'other_person_position',
        'facebook_url',
        'source_id',
        'added_by',
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function source(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class,  'client_id');
    }
    public function History(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientHistory::class,  'client_id');
    }
    public function latestStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ClientHistory::class, 'client_id')->latestOfMany();
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, ClientService::class)->withPivot('price');
    }

    public function calls(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Call::class,  'client_id');
    }

    public function whatsappMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WhatsappMessage::class,  'client_id');
    }

    public function meetings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Meeting::class,  'client_id');
    }

    public function checkStatus(int $status)
    {
        // switch($status)
        // {
        //     case ClientStatusEnum::NEW:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status);
        //         {
        //             throw new Exception(__('lang.the_current_status_is_new'));
        //         }
        //         break;
        //     case ClientStatusEnum::INTERESTED:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == ClientStatusEnum::NEW);
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     case ClientStatusEnum::NOT_INTERESTED:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == ClientStatusEnum::NEW);
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     case ClientStatusEnum::CONTACTED:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == );
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     case ClientStatusEnum::MEETING:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == );
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     case ClientStatusEnum::PROPOSAL:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == );
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     case ClientStatusEnum::CLOSED:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == );
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     case ClientStatusEnum::LOST:
        //         $currentStatus = $this->latestStatus->getRaworiginal('status');
        //         if($currentStatus == $status || $status == );
        //         {
        //             throw new Exception(__('lang.the_current_status_is_interested'));
        //         }
        //         break;
        //     default:
        //         return true;
        // }
    }

}
