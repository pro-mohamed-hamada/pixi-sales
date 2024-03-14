<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.calls') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('calls.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_call')}}</a></h5>
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
                
                <table class="callsTable  table text-center table-bordered  table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.client_name') }}</th>
                        <th>{{ __('lang.type') }}</th>
                        <th>{{ __('lang.date') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('lang.comment') }}</th>
                        <th>{{ __('lang.next_action') }}</th>
                        <th>{{ __('lang.next_action_date') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($calls as $call)
                        <tr>
                            <td>{{ $call->id }}</td>
                            <td>{{ $call->client->name }}</td>
                            <td>{{ $call->type }}</td>
                            <td>{{ $call->date }}</td>
                            <td>{{ $call->status }}</td>
                            <td>{{ $call->comment }}</td>
                            <td>{{ $call->next_action }}</td>
                            <td>{{ $call->next_action_date }}</td>
                            <td>
                                
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('calls.destroy', $call->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item"><a href="{{ route('calls.edit', $call->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                    <li class="list-group-item">
                                        <a target="_blank" class="btn btn-success" href="https://wa.me/{{ $call->client->phone }}?text=Hi"> 
                                            <i class="fa fa-whatsapp"></i>
                                        <a />
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr class=" displayView">
                            <td colspan="10">
                                <div class="displayViewContent">
                                    {{-- @include('Datatables.CallVisitsDatatable') --}}
                                </div>
                                <button class="close btn btn-danger">X</button>     
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $calls->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
</div>
