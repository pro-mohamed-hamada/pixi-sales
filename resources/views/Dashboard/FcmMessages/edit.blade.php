@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.edit_fcm_message') }}</div>

                    <div class="card-body">
                        {{-- start update form --}}
                        <form method="POST" action="{{ route('fcm-messages.update', $fcmMessage->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-md-4">
                                    <label>{{ __('lang.fcm_action') }} *</label>
                                    <select name="fcm_action" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($fcm_actions as $key=>$value)
                                            <option value="{{ $key }}" {{ $key == $fcmMessage->fcm_action ? "selected":"" }}>{{ $value }}</option>
                                        @endforeach
                                    <select>
                                    @error('fcm_action')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>{{ __('lang.notification_via') }} *</label>
                                    <select name="notification_via" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($fcm_channels as $key=>$value)
                                            <option value="{{ $key }}"  {{ $key == $fcmMessage->notification_via ? "selected":"" }}>{{ $value }}</option>
                                        @endforeach
                                    <select>
                                    @error('notification_via')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>{{ __('lang.title') }} *</label>
                                    <input type="text" name="title" value="{{ $fcmMessage->title }}" class="form-control">
                                    @error('title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label>{{ __('lang.content') }} *</label>
                                    <textarea name="content" class="form-control">{{ $fcmMessage->content }}</textarea>
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
                                
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input name="is_active" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $fcmMessage->getRawOriginal('is_active') ? "checked":"" }}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">{{ __('lang.is_active') }}</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.update')}}</button>
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
        @section('script')
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
