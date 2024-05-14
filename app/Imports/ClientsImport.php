<?php

namespace App\Imports;

use App\Enum\ActivationStatusEnum;
use App\Enum\ClientStatusEnum;
use App\Enum\TargetsEnum;
use App\Enum\UserTypeEnum;
use App\Models\City;
use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ClientsImport implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        DB::beginTransaction();
        $user = Auth::user();
        $row['added_by'] = $user->id;
        $row['assigned_to'] = isset($row['assigned_to']) ? $row['assigned_to']:$row['added_by'];

        $city = City::find($row['city_id']);
        if($city)
        {
            $row['phone'] = formatPhone(phone: $row['phone'], slug: $city?->governorate?->country?->slug);
            $row['other_person_phone'] = formatPhone(phone: $row['other_person_phone'], slug: $city?->governorate?->country?->slug);

        }

        // create the client
        $client = Client::create($row);
        $user->increaseUserTarget(TargetsEnum::CLIENT);
        //start add the client status
        // $statusData = app()->make(ClientService::class)->prepareStatusData(data: $row);
        $statusData = [];
        $statusData['status']    = Arr::get(array: $row, key: 'status', default: ClientStatusEnum::NEW);
        $statusData['reason_id'] = Arr::get(array: $row, key: 'reason_id', default: null);
        $statusData['comment']   = Arr::get(array: $row, key: 'comment', default: null);
        $statusData['added_by']   = Auth::user()->id;
        $statusData['date_time'] = Arr::get(array: $row, key: 'date_time', default: null);
        $client->history()->create($statusData);
        //end add the client status
        
        DB::commit();
        if (!$client)
            return false ;
        return $client;
        
    }

    public function rules(): array
    {
        return [
            'name'=>['required', 'string'],
            'phone'=>['required', 'unique:clients,phone', 'unique:clients,other_person_phone'],
            'industry_id'=>['required', 'integer', 'exists:industries,id'],
            'company_name'=>['required', 'string'],
            'city_id'=>['required', 'integer', 'exists:cities,id'],
            'other_person_name'=>['required', 'string'],
            'other_person_phone'=>['required', 'unique:clients,phone', 'unique:clients,other_person_phone'],
            'other_person_position'=>['required', 'string'],
            'facebook_url'=>['nullable', 'url'],
            'source_id'=>'required', 'integer', 'exists:sources,id',
            'assigned_to'=>'required', 'integer', 'exists:users,id',

            'status'=>['required', 'integer', 'in:'.ClientStatusEnum::NEW.','.ClientStatusEnum::CONTACTED.','.ClientStatusEnum::INTERESTED.','.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::PROPOSAL.','.ClientStatusEnum::MEETING.','.ClientStatusEnum::CLOSED.','.ClientStatusEnum::LOST],
            'reason_id'=>['nullable', 'exists:reasons,id', 'required_if:status,'.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::LOST],
            'comment'=>['nullable', 'string', 'required_if:status,'.ClientStatusEnum::NOT_INTERESTED],



        ];
    }

}
