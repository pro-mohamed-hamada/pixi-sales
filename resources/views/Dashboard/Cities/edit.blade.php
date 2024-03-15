@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.update_city') }}</div>

                    <div class="card-body">
                        {{-- start update form --}}
                        <form method="POST" action="{{ route('cities.update', $city->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-12">
                                    <label>{{ __('lang.governorate') }} *</label>
                                    <select name="governorate_id" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($governorates as $governorate)
                                            <option value="{{ $governorate->id }}" {{ $governorate->id == $city->governorate_id ? "selected":"" }}>{{ $governorate->name }}</option>
                                        @endforeach
                                    <select>
                                    @error('governorate_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.name') }} *</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $city->name }}" class="form-control">
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
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
   
