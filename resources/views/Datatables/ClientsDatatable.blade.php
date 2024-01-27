<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.clients') }}</div>

        <div class="card-body">
            <div class="">
                {{-- <h5><a role="button" class="btn btn-primary " href="{{route('clients.create')}}"><i class="fa fa-plus-circle"></i> {{__('lang.create_client')}}</a></h5> --}}
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
                
                <table class="clientsTable  table text-center table-bordered  table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.name') }}</th>
                        <th>{{ __('lang.phone') }}</th>
                        <th>{{ __('lang.city') }}</th>
                        <th>{{ __('lang.industry') }}</th>
                        <th>{{ __('lang.company_name') }}</th>
                        <th>{{ __('lang.other_person_name') }}</th>
                        <th>{{ __('lang.other_person_phone') }}</th>
                        <th>{{ __('lang.other_person_city') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                         {{-- -------------------------- --}}
                        
                         {{-- --------------------------- --}}
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->city->name }}</td>
                            <td>{{ $client->industry }}</td>
                            <td>{{ $client->company_name }}</td>
                            <td>{{ $client->other_person_name }}</td>
                            <td>{{ $client->other_person_phone }}</td>
                            <td>{{ $client->other_person_position }}</td>
                            <td>
                                
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('clients.destroy', $client->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item"><a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                    <li class="list-group-item"><a href="{{ route('clients.show', $client->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr class=" displayView">
                            <td colspan="10">
                                <div class="displayViewContent">
                                    @include('Datatables.ClientVisitsDatatable')
                                </div>
                                <button class="close btn btn-danger">X</button>     
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $clients->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
</div>
