@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_client') }}</div>

                    <div class="card-body">
                        @if(session()->has('failures'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('failures') as $failure)
                                        @foreach ($failure->errors() as $error)
                                            <li>Row {{ $failure->row() }}: {{ $error }}</li>
                                        @endforeach

                                        {{-- @foreach ($failure->values() as $attribute => $value)
                                            <li>In [{{ $attribute }}] with value [{{ $value }}]</li>
                                        @endforeach --}}
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- start update form --}}
                        <form method="POST" action="{{ route('clients.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3 g-3">
                                
                                <div class="col-lg-4">
                                    <label>{{ __('lang.file') }} *</label>
                                    <input type="file" name="file" value="{{ old('file') }}" class="form-control">
                                    @error('file')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
            
                            </div>
                            
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.import')}}</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{__('lang.go_back')}}</a>
                                </div>
                            </div>
                        </form>
                        {{-- end update form --}}
                    </div>
                </div>
            </div>

            
        </div>
        @endsection
<div id="relative" style="display: none !important">
    <div class="mb-3 relative">
        <div class="card">
            <div class="card-body">
                {{-- start update form --}}
                <div class="row mb-3 g-3">
                    <div class="col-lg-4">
                        <label>{{ __('lang.name') }} *</label>
                        <input type="text" name="relatives_name[]" class="form-control">
                        @error("relatives[0].name")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('lang.gender') }} *</label>
                        <select name="relatives_gender[]" class="form-control">
                            <option value="male">{{ __('lang.male') }}</option>
                            <option value="female">{{ __('lang.female') }}</option>
                        </select>
                        @error("relatives_gender[]")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('lang.identity_number') }} *</label>
                        <input type="text" name="relatives_identity_number[]" class="form-control">
                        @error("relatives_identity_number[]")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('lang.seat_number') }} *</label>
                        <input type="text" name="relatives_seat_number[]" class="form-control">
                        @error("relatives_seat_number[]")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('lang.country') }} *</label>
                        <input type="text" name="relatives_country[]" class="form-control">
                        @error("relatives_country[]")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('lang.city') }} *</label>
                        <input type="text" name="relatives_city[]" class="form-control">
                        @error("relatives_city[]")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 g-3">
                    <div class="relative-buttons">
                        <button type="button" class="btn btn-danger remove-relative"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                {{-- end update form --}}
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function(){
        $('#add-relative').click(function(){
            var element = $('#relative').html();
            $('.client-relatives').append(element);
        });
        $('.client-relatives').on('click', '.remove-relative', function(){
            var element = $(this).parents('.relative')
            element.remove();
        });
        $('#client_submit_button').click(function(e){
            e.preventDefault();
            var url = $('#client_form').attr("action");
            var data = $('#client_form').serialize();
            $.ajax({
                url:url,
                method:"post",
                data:data,
                beforeSend:function(){
                    $(".load_content").show();
                },
                success:function(responsetext){
                    $(".load_content").hide();
                    $(".alert_message").text('{{ __("lang.success_operation") }}');
                    $(".alert_message").fadeIn().delay(2000).fadeOut();
                    $(location).attr('href', "{{ route('clients.index') }}");
                },
                error: function(data_error, exception){
                    $(".load_content").hide();
                    if(exception == "error"){
                        $(".errors ul").text("");
                        $.each(data_error.responseJSON.errors, function(key, value) {
                            $(".errors ul").append("<li>" + key + ": " + value + "</li>");
                        });
                    }
                }
            });
        });

    });
</script>

@endsection
   
