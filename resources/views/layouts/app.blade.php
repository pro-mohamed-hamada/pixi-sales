<!doctype html>
<html dir="{{ app()->getLocale() == "en" ? "ltr":"rtl" }}"  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/pixi.jpg') }}" type="image/jpeg">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @if(app()->isLocale('ar'))
    <link href="{{ asset('css/rtl.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('css/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet"> -->
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="py-4">
            @include('layouts.sidebar')
            <div class="container-fluid">
                <div class="row ">
                    @include('layouts.header')
    
                    @yield('content')
                </div>
            </div>
        
        </main>
        
        <div class="load_content form-group text-center">
            <img class="load_image" src="{{asset('images/load_image.jpg')}}">
        </div>

        <div class="confirm_content form-group text-center">
            <div class="confirm_alert panel panel-primary">
                <div class="panel-body">
                    <h3>{{ __('lang.are_you_sure') }}</h3>
                    <button id="btn_no" class="btn btn-primary">{{ __('lang.no') }}</button>
                    <button id="btn_yes" class="btn btn-danger" data-href="">{{ __('lang.yes') }}</button>
                </div>
              </div>
        </div>
        {{-- start show photo section --}}
        <div id="show_photo" class="text-center col-xs-12">
        
        </div>
        {{-- end update section --}}
       
        <div style="display: none" class="alert_message alert alert-success" role="alert">
            
        </div>
        <div class=" displayView">
            <div class="displayViewContent">
                
            </div>
            <button class="close btn btn-danger">X</button>     
        </div>
    </div>
        {{-- end update section --}}
        
        <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('js/jquery.nicescroll.min.js')}}"></script>
        <script src="{{asset('js/js.js')}}"></script>
        @if(app()->isLocale('ar'))
        <script src="{{asset('js/rtl.js')}}"></script>
        @endif
</body>
<script>
    $(document).ready(function () {
        $("body").on("click", "button[name='delete']",function(e){
            e.preventDefault();
            $('#btn_yes').data('href', $(this).parent('form').attr('action'));
            $('.confirm_content').show();
            
        });
        if('{{ session("message") }}')
        {
            $(".alert_message").html('{{ session("message") }}');
            $(".alert_message").fadeIn().delay(2000).fadeOut();
        }
        $('body').on('click', '#btn_no', function(e){
            $('.confirm_content').hide();
        });
        $('body').on('click', '#btn_yes', function(e){
            var url = $(this).data('href');
            $('.confirm_content').hide();
            $.ajax({
                url:url,
                method:"post",
                data: {"_method":"delete", "_token": '{{ csrf_token() }}'},
                beforeSend:function(){
                    $(".load_content").show();
                },
                success:function(responsetext){
                    $(".load_content").hide();
                    $(".alert_message").text('{{ __("lang.success_operation") }}');
                    $(".alert_message").fadeIn().delay(2000).fadeOut();
                    $('.table-data').DataTable().ajax.reload(null, false);
                },
                error: function(data_error, exception){
                    $(".load_content").hide();
                    if(exception == "error"){
                        $(".alert_message").text(data_error.responseJSON.message);
                        $(".alert_message").fadeIn().delay(2000).fadeOut();
                    }
                }

            });
        });
    $("#countries").change(function () {
         var country_id = $(this).val();
         $('#governorates').html('');
        $.ajax({
            url: '{{ route("governorates.ajax") }}',
            type: 'get',
            data:{'country_id': country_id},
            success: function (res) {
                if (res.data != null)
                {
                    $('#governorates').html('<option>please select</option>');
                    $.each(res.data, function (key, value) {
                        $('#governorates').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }else
                $('#governorates').html('<option>please select</option>');

            }
        });
    });
    $("#governorates").change(function () {
         var governorate_id = $(this).val();
         $('#cities').html('');
        $.ajax({
            url: '{{ route("cities.ajax") }}',
            type: 'get',
            data:{'governorate_id': governorate_id},
            success: function (res) {
                if (res.data != null)
                {
                    $('#cities').html('<option>please select</option>');
                    $.each(res.data, function (key, value) {
                        $('#cities').append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }else
                $('#cities').html('<option>please select</option>');

            }
        });
    });
})

</script>

@yield('script')
</html>
