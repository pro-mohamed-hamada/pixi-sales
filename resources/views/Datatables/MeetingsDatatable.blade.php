<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.meetings') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('meetings.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_meeting')}}</a></h5>
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
                
                <table class="meetingsTable  table text-center table-bordered  table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.client_name') }}</th>
                        <th>{{ __('lang.date') }}</th>
                        <th>{{ __('lang.next_action') }}</th>
                        <th>{{ __('lang.next_action_date') }}</th>
                        <th>{{ __('lang.comment') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->id }}</td>
                            <td>{{ $meeting->client->name }}</td>
                            <td>{{ $meeting->date }}</td>
                            <td>{{ $meeting->next_action }}</td>
                            <td>{{ $meeting->next_action_date }}</td>
                            <td>{{ $meeting->comment }}</td>
                            <td>
                                
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('meetings.destroy', $meeting->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item"><a href="{{ route('meetings.edit', $meeting->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                    <li class="list-group-item">
                                        <a target="_blank" class="btn btn-success" href="https://wa.me/{{ $meeting->client->phone }}?text=Hi"> 
                                            <i class="fa fa-whatsapp"></i>
                                        <a />
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr class=" displayView">
                            <td colspan="10">
                                <div class="displayViewContent">
                                    {{-- @include('Datatables.MeetingVisitsDatatable') --}}
                                </div>
                                <button class="close btn btn-danger">X</button>     
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $meetings->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
</div>
