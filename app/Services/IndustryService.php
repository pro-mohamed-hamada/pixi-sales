<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use App\Models\Industry;
use App\QueryFilters\IndustriesFilter;
use Illuminate\Database\Eloquent\Model;

class IndustryService extends BaseService
{
    public function __construct(private Industry $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $industries = $this->getModel()->query()->with($withRelations);
        return $industries->filter(new IndustriesFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = null ): \Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Database\Eloquent\Collection
    {
        if($perPage)
            return $this->queryGet(filters: $filters, withRelations: $withRelations)->cursorPaginate($perPage);
        else
            return $this->queryGet(filters: $filters, withRelations: $withRelations)->get();
    }

    public function store(array $data = [])
    {
        $industry = $this->getModel()->create($data);
        if (!$industry)
            return false ;
        return $industry;
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
        $industry = $this->findById($id);
        return $industry->delete();
    } //end of delete

    // public function status($id)
    // {
    //     $doctor = $this->find($id);
    //     $doctor->is_active = !$doctor->is_active;
    //     return $doctor->save();

    // }//end of status

}
