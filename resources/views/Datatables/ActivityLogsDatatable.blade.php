<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.clients') }}</div>

        <div class="card-body">
            <div class="">
                {{-- <h5><a role="button" class="btn btn-primary " href="{{route('activity-logs.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_activity_log')}}</a></h5> --}}
            </div>
            <div class="search-box">
                <div class="row mb-3 g-3">
                    <div class="col-sm-2">
                        <select name="displaySelectBox" class="form-control">
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                            <option>{{ __('lang.show_all') }}</option>
                        </select>
                    </div>
                    <div class="col-sm-7 col-lg-10">
                        <input name="searchTxt" type="text" class="form-control" placeholder="{{__('lang.search')}}">
                    </div>
                </div>
            </div>

            <div class="datatable table-responsive">
                
                <table class="table text-center table-bordered table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.name') }}</th>
                        <th>{{ __('lang.start_work_time') }}</th>
                        <th>{{ __('lang.end_work_time') }}</th>
                        <th>{{ __('lang.hours') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($activityLogs as $activityLog)
                         
                        <tr>
                            <td>{{ $activityLog->id }}</td>
                            <td>{{ $activityLog->user->name }}</td>
                            <td>
                                <a href="https://www.google.com/maps/search/?api=1&query={{$activityLog->start_work_lat}},{{$activityLog->start_work_lng}}" target="_blank">
                                    {{ $activityLog->start_work_time }}
                                </a>
                            </td>
                            <td>
                                <a href="https://www.google.com/maps/search/?api=1&query={{$activityLog->end_work_lat}},{{$activityLog->end_work_lng}}" target="_blank">
                                    {{ $activityLog->end_work_time }}
                                </a>
                            </td>
                            <td>{{ $activityLog->hours }} hr</td>
                            <td>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('activity-logs.destroy', $activityLog->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item"><a href="{{ route('activity-logs.edit', $activityLog->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                    <li class="list-group-item"><a href="{{ route('activity-logs.show', $activityLog->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $activityLogs->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>