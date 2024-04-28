@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <form method="POST" action="{{ route('fcm.liveFcmMessage') }}" enctype="multipart/form-data">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_live_fcm_message') }}</div>

                    <div class="card-body">
                        {{-- start create form --}}
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-md-4">
                                    <label>{{ __('lang.notification_via') }} *</label>
                                    <select name="notification_via" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($fcm_channels as $key=>$value)
                                            <option value="{{ $key }}" {{ $key == old('notification_via') ? "selected":"" }}>{{ $value }}</option>
                                        @endforeach
                                    <select>
                                    @error('notification_via')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>{{ __('lang.title') }} *</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                    @error('title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label>{{ __('lang.content') }} *</label>
                                    <textarea name="content" class="form-control">{{ old('content') }}</textarea>
                                    @error('content')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label>{{ __('lang.flags') }} *</label>
                                    <div class="row  bg-light-dark">
                                        @foreach($flags as $key=>$flag)
                                            <div class="col-md-4 col-lg-4" style="cursor: pointer;padding: 10px;color: black" onclick="copyToClipboard('{{$flag}}')">{{$flag}}</div>
                                        @endforeach
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                        
                        {{-- end create form --}}
                    </div>
                </div>
                
            </div>
            {{-- start users --}}
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.users') }}</div>

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
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.create')}}</button>
                                <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{__('lang.go_back')}}</a>
                                <a href="{{ asset('imports/live_fcm_template.xlsx') }}"  class="btn btn-primary"><i class="fa fa-download"></i> {{__('lang.download_template')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end users --}}
            </form>
        </div>
        @endsection
        @section('script')
        <script>
            function copyToClipboard(text) {
                var sampleTextarea = document.createElement("textarea");
                document.body.appendChild(sampleTextarea);
                sampleTextarea.value = text; //save main text in it
                sampleTextarea.select(); //select textarea contenrs
                document.execCommand("copy");
                document.body.removeChild(sampleTextarea);
                $(".alert_message").text('Copy to Clipboard');
                $(".alert_message").fadeIn().delay(1000).fadeOut();
            }
        </script>
        @endsection
