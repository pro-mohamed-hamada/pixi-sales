@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_visit') }}</div>

                    <div class="card-body">
                        {{-- start create form --}}
                        <form method="POST" action="{{ route('visits.store') }}">
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-4">
                                    <label>{{ __('lang.client') }} *</label>
                                    <select name="client_id" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    <select>
                                    @error('client_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.country') }} *</label>
                                    <select id="countries" name="country_id" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    <select>
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.governorate') }} *</label>
                                    <select id="governorates" name="governorate_id" class="form-control">
                                    <select>
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.city') }} *</label>
                                    <select id="cities" name="city_id" class="form-control">
                                        
                                    <select>
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.date') }} *</label>
                                    <input type="date" name="date" class="form-control">
                                    @error('date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action') }} *</label>
                                    <select name="next_action" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::CALL }}">{{ __('lang.call') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::MEETING }}">{{ __('lang.meeting') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::WHATSAPP }}">{{ __('lang.whatsapp') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::VISIT }}">{{ __('lang.visit') }}</option>
                                        <select>
                                            @error('next_action')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action_date') }} *</label>
                                    <input type="datetime-local" name="next_action_date" class="form-control">
                                    @error('next_action_date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label>{{ __("lang.comment") }}</label>
                                    <textarea name="comment" class="form-control" placeholder="{{ __("lang.comment") }}"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.create')}}</button>
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