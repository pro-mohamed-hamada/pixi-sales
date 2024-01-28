<?php

namespace App\Services;

use App\Enum\ClientStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ClientService extends BaseService
{
    public function __construct(private Client $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $clients = $this->getModel()->query()->with($withRelations);
        return $clients->filter(new ClientsFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = []):Client|Model|bool
    {
        $client = $this->getModel()->create($data);
        $client->clientHistory()->create([
            "status"=>ClientStatusEnum::NEW
        ]);
        if (!$client)
            return false ;
        return $client;
    } //end of store

    public function changeStatus(int $id, array $data):bool
    {
        $client = $this->find($id);
        // $this->checkClientLatestStatus(client: $client, newStatus: $data['status']);
        $client->clientHistory()->create($data);
        if (!$client)
            return false ;
        return true;
    } //end of store

    public function checkClientLatestStatus(Client $client, int $newStatus)
    {
        $latestStatus = $client->latestStatus;
        dd($latestStatus->id);
        if($latestStatus->status == $newStatus)
            throw new Exception(message: __('lang.the_status_can_not_be_the_same'), code: 442);
    }

    // public function update(int $id, array $data=[])
    // {
    //     $doctor = $this->find($id);
    //     if (!$doctor)
    //         return false;
    //     if (isset($data['logo']))
    //     {
    //         if ($doctor->attachments()->count())
    //             $doctor->deleteAttachments();
    //         $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/doctors', field_name: 'logo');
    //         $fileData['type'] = ImageTypeEnum::LOGO;
    //         $doctor->storeAttachment($fileData);
    //     }
    //     $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
    //     $doctor->update($data);
    //     return $doctor;
    // }

    /**
     * @throws NotFoundException
     */
    public function find(int $clientId , array $withRelations = []): Client|Model|bool
    {
        $client =  $this->getModel()->with($withRelations)->find($clientId);
        if (!$client)
           throw new NotFoundException(trans('lang.not_found'));
        return $client;
    }

    /**
     * @throws NotFoundException
     */
    public function delete($id)
    {
        $doctor = $this->find($id);
        $doctor->deleteAttachments();
        return $doctor->delete();
    } //end of delete

    public function status($id)
    {
        $doctor = $this->find($id);
        $doctor->is_active = !$doctor->is_active;
        return $doctor->save();

    }//end of status

}
