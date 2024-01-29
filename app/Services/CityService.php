<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Client;
use App\QueryFilters\ClientsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\City;
use App\Models\Governorate;
use App\QueryFilters\CitiesFilter;
use Illuminate\Database\Eloquent\Model;

class CityService extends BaseService
{
    public function __construct(private City $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $cities = $this->getModel()->query()->with($withRelations);
        return $cities->filter(new CitiesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $city = $this->getModel()->create($data);
        if (!$city)
            return false ;
        return $city;
    } //end of store

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

    // /**
    //  * @throws NotFoundException
    //  */
    // public function find(int $doctorId , array $withRelations = []): Doctor|Model|bool
    // {
    //     $doctor =  Doctor::with($withRelations)->find($doctorId);
    //     if (!$doctor)
    //        throw new NotFoundException(trans('lang.doctor_no_found'));
    //     return $doctor;
    // }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $city = $this->findById($id);
        return $city->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
