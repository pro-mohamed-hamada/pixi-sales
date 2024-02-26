@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.edit_whatsapp_template') }}</div>

                    <div class="card-body">
                        {{-- start edit form --}}
                        <form method="POST" action="{{ route('whatsapp-templates.update', $whatsappTemplate->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-md-4">
                                    <label>{{ __('lang.action') }} *</label>
                                    <select name="action" class="form-control">
                                        <option>{{ __('lang.choose') }}</option>
                                        @foreach(\App\Enum\WhatsappEventsNames::$ACTIONS as $key=>$action)
                                            <option value="{{ $key }}" {{ $key == $whatsappTemplate->action ? "selected":"" }}>{{ __('lang.'.$action) }}</option>
                                        @endforeach
                                    </select>
                                    @error('action')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.title') }} *</label>
                                    <input type="text" name="title" value="{{ $whatsappTemplate->title }}" class="form-control">
                                    @error('title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>{{ __('lang.content') }} *</label>
                                    <textarea name="content" class="form-control">{{ $whatsappTemplate->content }}</textarea>
                                    @error('content')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label>{{ __('lang.flags') }} *</label>
                                    <div class="row  bg-light-dark">
                                        @foreach(\App\Enum\WhatsappEventsNames::$WHATSAPP_TEMPLATES_FLAGS as $key=>$flag)
                                            <div class="col-md-4 col-lg-4" style="cursor: pointer;padding: 10px;color: black" onclick="copyToClipboard('{{$flag}}')">{{$flag}}</div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <label>{{ __('lang.comment') }} *</label>
                                    <textarea name="comment" class="form-control">{{ $whatsappTemplate->comment }}</textarea>
                                    @error('comment')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input name="is_active" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">{{ __('lang.is_active') }}</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {{__('lang.edit')}}</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{__('lang.go_back')}}</a>
                                </div>
                            </div>
                        </form>
                        {{-- end edit form --}}
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
                toastr.info('Copy to Clipboard')
            }
        </script>
        @endsection
