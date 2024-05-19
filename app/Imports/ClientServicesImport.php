<?php

namespace App\Imports;

use App\Enum\ActionTypeEnum;
use App\Enum\ActivationStatusEnum;
use App\Enum\ClientActivityActionEnum;
use App\Enum\CurrencyEnum;
use App\Enum\UserTypeEnum;
use App\Models\Client;
use App\Models\User;
use App\Models\ClientService as ModelsClientService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
class ClientServicesImport implements ToModel, ToCollection, SkipsEmptyRows, WithValidation, WithHeadingRow
{

    // Add a constructor to accept the request
    public function __construct()
    {
        //
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // DB::beginTransaction();
        // $client = Client::where('phone', $row['phone'])->first();
        // if(!$client)
        //     return null;
        // $servicesData = [];
        // $nextAction = isset($row['next_action']) ? $row['next_action']:null;
        // $nextActionDate = isset($row['next_action_date']) ? $row['next_action_date']:null;
        // $comment = isset($row['comment']) ? $row['comment']:null;
        // $addedBy = Auth::user()->id;
        // if(Arr::has(array: $row, keys: 'services'))
        // {
        //     for($i=0; $i<count($row['services']); $i++)
        //     {
        //         $servicesData[$row['services'][$i]] = ['price'=> $row['prices'][$i], 'next_action'=>$nextAction,'next_action_date'=>$nextActionDate, 'comment'=>$comment, 'added_by'=>$addedBy];
        //     }
        // }
        // if($servicesData)
        // {
        //     $client->services()->sync($servicesData);
        //     foreach($client->services as $service)
        //     {
        //         $clientService = ModelsClientService::where('client_id', $client->id)
        //         ->where('service_id', $service->id)->first();
        //         if($clientService)
        //             $clientService->activities()->create([ 'client_id'=>$client->id, 'action'=>ClientActivityActionEnum::ADDED]);
        //     }
        // }
        // DB::commit();
        // return $service;
        
    }

    public function collection(Collection $rows)
    {
        $addedBy = Auth::user()->id;
        $previousPhone = $rows[0]['phone'];
        $servicesData = [];
        foreach ($rows as $row) 
        {
            $service_id = isset($row['service']) ? substr($row['service'], (strpos($row['service'], "#") + 1)) : null;
            DB::beginTransaction();
            if($row['phone'] == $previousPhone)
            {
                $previousPhone = $row['phone'];
                $servicesData[$service_id] = ['price'=> $row['price'], 'currency'=> $row['currency'], 'next_action'=>$row['next_action'],'next_action_date'=>$row['next_action_date'], 'comment'=>$row['comment'], 'added_by'=>$addedBy];
                $client = Client::where('phone','like', '%'.$row['phone'])->first();
                if($client)
                {
                    $client->services()->sync($servicesData);
                }
            }else{
                $client = Client::where('phone','like', '%'.$row['phone'])->first();
                if($client)
                {
                    $client->services()->sync($servicesData);
                }
                $previousPhone = $row['phone'];
                $servicesData = [];
                $servicesData[$service_id] = ['price'=> $row['price'], 'next_action'=>$row['next_action'],'next_action_date'=>$row['next_action_date'], 'comment'=>$row['comment'], 'added_by'=>$addedBy];
            }
            
            DB::commit();

        }
    }

    public function rules(): array
    {
        return [
            'service'=>['required', 'string'],
            'price'=>['required', 'numeric'],
            'currency'=>['required', 'string', 'in:'.CurrencyEnum::EGP.','.CurrencyEnum::USD],
            'next_action'=>['nullable', 'required_with:next_action_date', 'integer', 'in:'.ActionTypeEnum::CALL.','.ActionTypeEnum::MEETING.','.ActionTypeEnum::WHATSAPP.','.ActionTypeEnum::VISIT],
            'next_action_date'=>['nullable', 'required_with:next_action', 'date', 'after:'.Carbon::now()],
            'comment'=>['nullable', 'string'],
        ];
    }

}
