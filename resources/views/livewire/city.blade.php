<div>
    <label>{{ $title }} *</label>
    <select name="{{$field_name}}" class="form-control form-select">
        @if(!isset($selected_city))
            <option value="" selected>{{ __('lang.select_city') }}</option>
        @endif
    
        @foreach($cities?? [] as $city)
            <option value="{{$city->id}}" {{$city->id == old("$field_name")?'selected':''}}>{{$city->name}}</option>
        @endforeach
    </select>
    @error($field_name)
        <span class="error">{{ $message }}</span>
    @enderror
</div>

