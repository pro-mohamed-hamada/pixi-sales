@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.edit_country') }}</div>

                    <div class="card-body">
                        {{-- start update form --}}
                        <form method="POST" action="{{ route('countries.update', $country->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-6">
                                    <label>{{ __('lang.name') }} *</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $country->name }}" class="form-control">
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="col-lg-6">
                                    <label>{{ __('lang.slug') }} *</label>
                                    <input type="text" name="slug" value="{{ old('slug') ?? $country->slug }}" class="form-control">
                                    @error('slug')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="col-lg-6">
                                    <label>{{ __('lang.code') }} *</label>
                                    <input type="text" name="code" value="{{ old('code') ?? $country->code }}" class="form-control">
                                    @error('code')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input name="is_active" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $country->getRawOriginal('is_active') ? "checked":"" }}>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">{{ __('lang.is_active') }}</label>
                                </div>
                            </div>
                        <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> {{__('lang.update')}}</button>
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
   
