@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_service') }}</div>

                    <div class="card-body">
                        {{-- start create form --}}
                        <form method="POST" action="{{ route('services.store') }}">
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-6">
                                    <label>{{ __('lang.name_ar') }} *</label>
                                    <input type="text" name="name[ar]" class="form-control">
                                    @error('name.ar')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>{{ __('lang.name_en') }} *</label>
                                    <input type="text" name="name[en]" class="form-control">
                                    @error('name.en')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>{{ __('lang.is_active') }} *</label>
                                    <select name="is_active" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        <option value="{{ \App\Enum\ActivationStatusEnum::ACTIVE }}">{{ __('lang.active') }}</option>
                                        <option value="{{ \App\Enum\ActivationStatusEnum::NOTACTIVE }}">{{ __('lang.not_active') }}</option>
                                    <select>
                                    @error('is_active')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {{__('lang.create')}}</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{__('lang.go_back')}}</a>
                                </div>
                            </div>
                        </form>
                        {{-- end create form --}}
                    </div>
                </div>
            </div>
            
        </div>
        @endsection
   
