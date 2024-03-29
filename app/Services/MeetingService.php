<?php

namespace App\Services;

use App\Enum\TargetsEnum;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Meeting;
use App\QueryFilters\MeetingsFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeetingService extends BaseService
{
    public function __construct(private Meeting $model){

    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function queryGet(array $filters = [] , array $withRelations = []) :builder
    {
        $meetings = $this->getModel()->query()->with($withRelations);
        return $meetings->filter(new MeetingsFilter($filters));
    }

    public function getAll(array $filters = [] , array $withRelations =[], $perPage = 10 ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->queryGet(filters: $filters,withRelations: $withRelations)->cursorPaginate($perPage);
    }

    public function store(array $data = []):Meeting|bool
    {
        $user = Auth::user();
        $data['added_by'] = $user->id;
        DB::beginTransaction();
        $meeting = $this->getModel()->create($data);
        $user->increaseUserTarget(TargetsEnum::MEETING);
        DB::commit();
        if (!$meeting)
            return false ;
        //TODO: send whatsapp message for the client
        return $meeting;
    } //end of store

    public function update(int $id, array $data=[]):Meeting
    {
        $meeting = $this->findById(id: $id);
        $meeting->update($data);
        return $meeting;
    }

    /**
     * @throws NotFoundException
     */
    public function destroy($id)
    {
        $meeting = $this->findById($id);
        return $meeting->delete();
    } //end of delete

}
