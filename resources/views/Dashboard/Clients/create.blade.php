@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            {{-- start create form --}}
            <form method="POST" action="{{ route('clients.store') }}">
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('lang.create_client') }}</div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                @csrf
                                <div class="row mb-3 g-3">
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.governorate') }} *</label>
                                        <select id="governorates" name="governorate_id" class="form-control">
                                            <option selected disabled>{{ __("lang.choose") }}</option>
                                            @foreach ($governorates as $governorate)
                                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                            @endforeach
                                        <select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.city') }} *</label>
                                        <select id="governorate_cities" name="city_id" class="form-control">
                                            
                                        <select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.name') }} *</label>
                                        <input type="text" name="name" class="form-control">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.phone') }} *</label>
                                        <input type="tel" name="phone" class="form-control">
                                        @error('phone')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.industry') }} *</label>
                                        <input type="text" name="industry" class="form-control">
                                        @error('industry')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.company_name') }} *</label>
                                        <input type="text" name="company_name" class="form-control">
                                        @error('company_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.other_person_name') }} *</label>
                                        <input type="text" name="other_person_name" class="form-control">
                                        @error('other_person_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.other_person_phone') }} *</label>
                                        <input type="text" name="other_person_phone" class="form-control">
                                        @error('other_person_phone')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.other_person_position') }} *</label>
                                        <input type="text" name="other_person_position" class="form-control">
                                        @error('other_person_position')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                </div>
                {{-- start the client history --}}
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('lang.change_client_status') }}</div>

                        <div class="card-body">
                            
                                <div class="row mb-3 g-3">
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.status') }} *</label>
                                        <select name="status" class="form-control">
                                            <option selected disabled>{{ __("lang.choose") }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::NEW }}">{{ __('lang.new') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::CONTACTED }}">{{ __('lang.contacted') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::INTERESTED }}">{{ __('lang.interested') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::NOT_INTERESTED }}">{{ __('lang.not_interested') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::PROPOSAL }}">{{ __('lang.proposal') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::MEETING }}">{{ __('lang.meeting') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::CLOSED }}">{{ __('lang.closed') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::LOST }}">{{ __('lang.lost') }}</option>
                                        <select>
                                        @error('status')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.reason') }}</label>
                                        <select name="reason_id" class="form-control">
                                            <option value="" selected>{{ __("lang.no_reason") }}</option>
                                            @foreach ($reasons as $reason)
                                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                            @endforeach
                                        <select>
                                        @error('reason_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.date_time') }}</label>
                                        <input type="datetime-local" name="date_time" class="form-control" placeholder="{{ __('lang.date_time') }}">
                                        @error('date_time')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <label>{{ __('lang.comment') }}</label>
                                        <textarea name="comment" class="form-control" placeholder="{{ __('lang.comment') }}"></textarea>
                                        @error('comment')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                </div>
                {{-- end the client history --}}

                {{-- start the client services --}}
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('lang.client_services') }}</div>

                        <div class="card-body">
                            
                                <div class="row mb-3 g-3">
                                    @foreach ($services as $service)
                                        <div class="col-lg-3">
                                            <label>{{ $service->name }}</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                <input name="services[]" class="form-check-input mt-0" type="checkbox" value="{{ $service->id }}">
                                                </div>
                                                <input name="prices[]" type="text" class="form-control" aria-label="Text input with checkbox">
                                            </div>
                                            @error('prices')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                                
                        </div>
                    </div>
                </div>
                {{-- end the client services --}}
                <div class="row mb-3 g-3">
                    <div class="">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.create')}}</button>
                        <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{__('lang.go_back')}}</a>
                    </div>
                </div>
            </form>
            {{-- end create form --}}
        </div>
        @endsection
   
