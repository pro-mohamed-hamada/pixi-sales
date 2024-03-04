<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Enum\ImageTypeEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserTypeEnum;
use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserTarget;
use App\QueryFilters\UsersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{

    public function __construct(private User $model)
    {
        
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $filters['type'] = UserTypeEnum::EMPLOYEE;
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $services = $this->getModel()->query()->with($withRelations);
        return $services->filter(new UsersFilter($filters));
    }

    public function getModel(): Model
    {
        return $this->model;
    }
    public function store(array $data = [])
    {
        DB::beginTransaction();
        $data['is_active'] = isset($data['is_active']) ? ActivationStatusEnum::ACTIVE:ActivationStatusEnum::NOT_ACTIVE;
        $user = $this->getModel()->create($data);
        if (!$user)
            return false ;
        $userTargetsData = $this->prepareTargetsData($data);
        
        $user->targets()->createMany($userTargetsData);
        DB::commit();
        if (!$user)
            return false ;
        return $user;
    } //end of store

    private function prepareTargetsData(array $data): array
    {
        $userTargetsData = [];
        if(isset($data['userTargets_target']))
            for($i = 0; $i< count($data['userTargets_target']); $i++)
            {
                $userTargetsData[$i]['target'] = $data['userTargets_target'][$i];
                $userTargetsData[$i]['target_value'] = $data['userTargets_target_value'][$i];
                $userTargetsData[$i]['target_done'] = $data['userTargets_target_done'][$i];
            }
        return $userTargetsData;
    }


    public function changeStatus($id)
    {
        $user = $this->findById($id);
        $user->is_active = !$user->is_active;
        $user->save();
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    } //end of delete

}
