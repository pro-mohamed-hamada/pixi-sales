<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.whatsappMessages') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('whatsapp-messages.create')}}"><i class="fa fa-plus-circle"></i> {{__('lang.create_whatsappMessage')}}</a></h5>
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
                
                <table class="whatsappMessagesTable  table text-center table-bordered  table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.client_name') }}</th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('lang.content') }}</th>
                        <th>{{ __('lang.phone') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($whatsappMessages as $whatsappMessage)
                        <tr>
                            <td>{{ $whatsappMessage->id }}</td>
                            <td>{{ $whatsappMessage->client->name }}</td>
                            <td>{{ $whatsappMessage->title }}</td>
                            <td>{{ $whatsappMessage->content }}</td>
                            <td>{{ $whatsappMessage->phone }}</td>
                            <td>
                                
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('whatsapp-messages.destroy', $whatsappMessage->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item">
                                        <a target="_blank" class="btn btn-success" href="https://wa.me/{{ $whatsappMessage->phone }}?text={{ $whatsappMessage->content }}"> 
                                            <i class="fa fa-whatsapp"></i>
                                        <a />
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr class=" displayView">
                            <td colspan="10">
                                <div class="displayViewContent">
                                    {{-- @include('Datatables.WhatsappMessageVisitsDatatable') --}}
                                </div>
                                <button class="close btn btn-danger">X</button>     
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $whatsappMessages->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
</div>
