<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.visits') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('visits.create')}}"><i class="fa fa-plus-circle"></i> {{__('lang.create_visit')}}</a></h5>
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
                        <th>{{ __('lang.client_name') }}</th>
                        <th>{{ __('lang.action_type') }}</th>
                        <th>{{ __('lang.comment') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($visits as $visit)
                         
                        <tr>
                            <td>{{ $visit->id }}</td>
                            <td>{{ $visit->client->name }}</td>
                            <td>{{ $visit->action_type }}</td>
                            <td>{{ $visit->comment }}</td>
                            <td>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('visits.destroy', $visit->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item"><a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                    <li class="list-group-item"><a href="{{ route('visits.show', $visit->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $visits->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>
</div>