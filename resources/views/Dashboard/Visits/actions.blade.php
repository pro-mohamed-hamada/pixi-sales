<ul class="list-group list-group-horizontal">
    <li class="list-group-item">
        <form method="post" action="{{route('visits.destroy', $model->id)}}">
            @csrf
            @method('delete')
            <button type="submit" name="delete" class=" btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
    </li>
    <li class="list-group-item"><a href="{{ route('visits.edit', $model->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></li>
    <li class="list-group-item"><a href="{{ route('visits.show', $model->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></li>
</ul>