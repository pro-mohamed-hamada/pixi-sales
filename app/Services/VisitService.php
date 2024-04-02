<?php

namespace App\Services;

use App\Enum\ClientActivityActionEnum;
use App\Enum\TargetsEnum;
use App\Exceptions\NotFoundException;
use App\Models\Visit;
use App\QueryFilters\VisitsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VisitService extends BaseService
{
    public function __construct(private Visit $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $visits = $this->getModel()->query()->with($withRelations);
        return $visits->filter(new VisitsFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $user = Auth::user();
        $data['added_by'] = $user->id;
        DB::beginTransaction();
        $visit = $this->getModel()->create($data);
        $user->increaseUserTarget(TargetsEnum::VISIT);
        $visit->activities()->create([ 'client_id'=>$visit->client->id, 'action'=>ClientActivityActionEnum::ADDED]);
        DB::commit();
        if (!$visit)
            return false ;
        return $visit;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $visit = $this->findById(id: $id);
        $visit->update($data);
        $visit->activities()->create([ 'client_id'=>$visit->client->id, 'action'=>ClientActivityActionEnum::UPDATED]);
        return $visit;
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $visit = $this->findById($id);
        return $visit->delete();
    } //end of delete


}
