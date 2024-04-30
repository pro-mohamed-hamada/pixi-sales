<?php

namespace App\Models;

use App\Enum\ClientStatusEnum;
use App\Http\Resources\LatestActionResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;

class Client extends Model
{
    use HasFactory, Filterable;


    protected $fillable = [
        'name',
        'phone',
        'industry_id',
        'company_name',
        'city_id',
        'other_person_name',
        'other_person_phone',
        'other_person_position',
        'facebook_url',
        'source_id',
        'added_by',
        'assigned_to',
        'lat',
        'lng',
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function source(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function industry(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function assignedTo(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class,  'client_id');
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientActivity::class,  'client_id');
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
        return $this->belongsToMany(Service::class, ClientService::class)->withPivot('price', 'next_action', 'next_action_date', 'comment');
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

    public function getLatestAction()
    {
        $visit = !empty($this->visits()->whereNotNull('next_action')->latest()->first()) ? $this->visits()->whereNotNull('next_action')->latest()->first():null;
        $call = !empty($this->calls()->whereNotNull('next_action')->latest()->first()) ? $this->calls()->whereNotNull('next_action')->latest()->first():null;
        $meeting = !empty($this->meetings()->whereNotNull('next_action')->latest()->first()) ? $this->meetings()->whereNotNull('next_action')->latest()->first():null;           

        $greatestDate = null;
        $greatestDate = max($visit?->created_at, $call?->created_at,$meeting?->created_at);

        $model = null;
        if($greatestDate)
        {
            if ($greatestDate->equalTo($visit?->created_at))
                $model = $visit;
            elseif ($greatestDate->equalTo($call?->created_at))
                $model = $call;
            elseif ($greatestDate->equalTo($meeting?->created_at))
                $model = $meeting;
        }

        return !empty($model) ? new LatestActionResource($model):null;
        // Now you can use $mostRecentModel as needed

    }

    public function getIconAttribute()
    {
        return asset('targets/clients.jpeg');
    }

    public function checkStatus(int $status)
    {
        $response = false;
        $currentStatus = $this->latestStatus->getRaworiginal('status');
        switch($status)
        {
            case ClientStatusEnum::NEW:
                if(Arr::has([
                    ClientStatusEnum::CONTACTED,
                    ClientStatusEnum::INTERESTED,
                    ClientStatusEnum::NOT_INTERESTED,
                    ClientStatusEnum::PROPOSAL,
                    ClientStatusEnum::MEETING,
                    ClientStatusEnum::CLOSED,
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;

                break;
            case ClientStatusEnum::CONTACTED:
                if(Arr::has([
                    ClientStatusEnum::INTERESTED,
                    ClientStatusEnum::NOT_INTERESTED,
                    ClientStatusEnum::PROPOSAL,
                    ClientStatusEnum::MEETING,
                    ClientStatusEnum::CLOSED,
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;
                break;
            case ClientStatusEnum::INTERESTED:
                if(Arr::has([
                    ClientStatusEnum::NOT_INTERESTED,
                    ClientStatusEnum::PROPOSAL,
                    ClientStatusEnum::MEETING,
                    ClientStatusEnum::CLOSED,
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;
                break;
            case ClientStatusEnum::NOT_INTERESTED:
                if(Arr::has([
                    ClientStatusEnum::PROPOSAL,
                    ClientStatusEnum::MEETING,
                    ClientStatusEnum::CLOSED,
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;
                break;
            case ClientStatusEnum::PROPOSAL:
                if(Arr::has([
                    ClientStatusEnum::MEETING,
                    ClientStatusEnum::CLOSED,
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;
                break;
            case ClientStatusEnum::MEETING:
                if(Arr::has([
                    ClientStatusEnum::CLOSED,
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;
                break;
            case ClientStatusEnum::CLOSED:
                if(Arr::has([
                    ClientStatusEnum::LOST
                ], $currentStatus)){
                    throw new Exception(__('lang.not_allowed'));
                }
                $response = true;
                break;
            case ClientStatusEnum::LOST:
                //TODO: check this
                $response = true;
                break;
            default:
                return true;
        }
        return $response;
    }

}
