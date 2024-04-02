<ul class="list-group list-group-horizontal">
    <li class="list-group-item">
        <form method="post" action="{{route('sources.destroy', $model->id)}}">
            @csrf
            @method('delete')
            <button type="submit" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
    </li>
    <li class="list-group-item"><a href="{{ route('sources.edit', $model->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
    {{-- <li class="list-group-item"><a href="{{ route('sources.show', $model->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li> --}}
</ul>
