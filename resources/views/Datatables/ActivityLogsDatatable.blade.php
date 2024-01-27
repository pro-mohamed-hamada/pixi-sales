<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.clients') }}</div>

        <div class="card-body">
            <div class="">
                {{-- <h5><a role="button" class="btn btn-primary " href="{{route('activity-logs.create')}}"><i class="fa fa-plus-circle"></i> {{__('lang.create_activity_log')}}</a></h5> --}}
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
                
                <table class="table text-center table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.name') }}</th>
                        <th>{{ __('lang.login_time') }}</th>
                        <th>{{ __('lang.logout_time') }}</th>
                        <th>{{ __('lang.hours') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($activityLogs as $activityLog)
                         
                        <tr>
                            <td>{{ $activityLog->id }}</td>
                            <td>{{ $activityLog->user->name }}</td>
                            <td>
                                <a href="https://www.google.com/maps/search/?api=1&query={{$activityLog->login_lat}},{{$activityLog->login_lng}}" target="_blank">
                                    {{ $activityLog->login_time }}
                                </a>
                            </td>
                            <td>
                                <a href="https://www.google.com/maps/search/?api=1&query={{$activityLog->logout_lat}},{{$activityLog->logout_lng}}" target="_blank">
                                    {{ $activityLog->logout_time }}
                                </a>
                            </td>
                            <td>{{ $activityLog->hours }} hr</td>
                            <td>
                                <div class="row mb-3 g-3">
                                    <div class="">
                                        <form method="post" action="{{route('activity-logs.destroy', $activityLog->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <a href="{{ route('activity-logs.edit', $activityLog->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('activity-logs.show', $activityLog->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
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