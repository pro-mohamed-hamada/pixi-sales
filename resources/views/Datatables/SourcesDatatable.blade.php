<div class="mb-3">
    <div class="card">
        <div class="card-header">{{ __('lang.sources') }}</div>

        <div class="card-body">
            <div class="">
                <h5><a role="button" class="btn btn-primary " href="{{route('sources.create')}}"><i class="fa fa-plus"></i> {{__('lang.create_source')}}</a></h5>
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
                
                <table class="sourcesTable  table text-center table-bordered  table-hover">
                    <thead>
                        <th>{{ __('lang.id') }}</th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($sources as $source)
                        <tr>
                            <td>{{ $source->id }}</td>
                            <td>{{ $source->title }}</td>
                            <td>
                                
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">
                                        <form method="post" action="{{route('sources.destroy', $source->id)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </li>
                                    <li class="list-group-item"><a href="{{ route('sources.edit', $source->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
                                    <li class="list-group-item"><a href="{{ route('sources.show', $source->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{ $sources->links() }}                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
</div>
