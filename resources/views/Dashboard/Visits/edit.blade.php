@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.edit_visit') }}</div>

                    <div class="card-body">
                        {{-- start edit form --}}
                        <form method="POST" action="{{ route('visits.update', $visit->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-4">
                                    <label>{{ __('lang.client') }} *</label>
                                    <select name="client_id" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{$client->id == $visit->client_id ? "selected":""}}>{{ $client->name }}</option>
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
                                            <option value="{{ $country->id }}" {{ $country->id == $visit->city->governorate->country_id ? "selected":"" }}>{{ $country->name }}</option>
                                        @endforeach
                                    <select>
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.governorate') }} *</label>
                                    <select id="governorates" name="governorate_id" class="form-control">
                                        @foreach ($visit->city->governorate->country->governorates as $governorate)
                                        <option value="{{ $governorate->id }}" {{ $governorate->id == $visit->city->governorate_id ? "selected":"" }}>{{ $governorate->name }}</option>
                                        @endforeach
                                    <select>
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.city') }} *</label>
                                    <select id="cities" name="city_id" class="form-control">
                                        @foreach($visit->city->governorate->cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id == $visit->city_id ? "selected":"" }}>{{$city->name}}</option>
                                        @endforeach
                                    <select>
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.date') }} *</label>
                                    <input type="date" name="date" value="{{$visit->date}}" class="form-control">
                                    @error('date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action') }} *</label>
                                    <select name="next_action" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::CALL }}" {{ \App\Enum\ActionTypeEnum::CALL == $visit->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.call') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::MEETING }}" {{ \App\Enum\ActionTypeEnum::MEETING == $visit->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.meeting') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::WHATSAPP }}" {{ \App\Enum\ActionTypeEnum::WHATSAPP == $visit->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.whatsapp') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::VISIT }}" {{ \App\Enum\ActionTypeEnum::VISIT == $visit->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.visit') }}</option>
                                        <select>
                                            @error('next_action')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action_date') }} *</label>
                                    <input type="datetime-local" name="next_action_date" value="{{ $visit->next_action_date }}" class="form-control">
                                    @error('next_action_date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label>{{ __("lang.comment") }}</label>
                                    <textarea name="comment" class="form-control" placeholder="{{ __("lang.comment") }}">{{ $visit->comment }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> {{__('lang.update')}}</button>
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
