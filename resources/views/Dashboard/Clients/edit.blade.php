@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <form method="POST" action="{{ route('clients.update', $client->id) }}">
                @method("PUT")
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('lang.edit_client') }}</div>

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
                            {{-- start update form --}}
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
                                            @foreach($client->city->governorate->cities as $city)
                                                <option value="{{ $city->id }}" {{ $city->id == $client->city_id ? "selected":"" }}>{{$city->name}}</option>
                                            @endforeach
                                        <select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.name') }} *</label>
                                        <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.phone') }} *</label>
                                        <input type="tel" name="phone" class="form-control" value="{{ $client->phone }}">
                                        @error('phone')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.industry') }} *</label>
                                        <select name="industry_id" class="form-control">
                                            <option selected disabled>{{ __("lang.choose") }}</option>
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}" {{ $industry->id == $client->industry_id ? "selected":"" }}>{{ $industry->name }}</option>
                                            @endforeach
                                        <select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.company_name') }} *</label>
                                        <input type="text" name="company_name" class="form-control" value="{{ $client->company_name }}">
                                        @error('company_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.other_person_name') }} *</label>
                                        <input type="text" name="other_person_name" class="form-control" value="{{ $client->other_person_name }}">
                                        @error('other_person_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.other_person_phone') }} *</label>
                                        <input type="text" name="other_person_phone" class="form-control" value="{{ $client->other_person_phone }}">
                                        @error('other_person_phone')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.other_person_position') }} *</label>
                                        <input type="text" name="other_person_position" class="form-control" value="{{ $client->other_person_position }}">
                                        @error('other_person_position')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.source') }} *</label>
                                        <select name="source_id" class="form-control">
                                            <option selected disabled>{{ __("lang.choose") }}</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}" {{ $source->id == $client->source_id ? "selected":"" }}>{{ $source->title }}</option>
                                            @endforeach
                                        <select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.assigned_to') }} *</label>
                                        <select name="assigned_to" class="form-control">
                                            <option value="" selected disabled>{{ __("lang.choose") }}</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ $employee->id == $client->assigned_to ? "selected":"" }}>{{ $employee->name }}</option>
                                            @endforeach
                                        <select>
                                        @error('assigned_to')
                                            <span class="error">{{ $message }}</span>
                                        @enderror    
                                    </div>

                                </div>
                            {{-- end update form --}}
                        </div>
                    </div>
                </div>

                {{-- start the client history --}}
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('lang.change_client_status') }}</div>

                        <div class="card-body">
                            {{-- start update form --}}
                                <div class="row mb-3 g-3">
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.status') }} *</label>
                                        <select name="status" class="form-control">
                                            <option disabled>{{ __("lang.choose") }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::NEW }}" {{ $client->latestStatus?->status == \App\Enum\ClientStatusEnum::NEW? "selected":""}}>{{ __('lang.new') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::CONTACTED }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::CONTACTED? "selected":""}}>{{ __('lang.contacted') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::INTERESTED }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::INTERESTED? "selected":""}}>{{ __('lang.interested') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::NOT_INTERESTED }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::NOT_INTERESTED? "selected":""}}>{{ __('lang.not_interested') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::PROPOSAL }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::PROPOSAL? "selected":""}}>{{ __('lang.proposal') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::MEETING }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::MEETING? "selected":""}}>{{ __('lang.meeting') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::CLOSED }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::CLOSED? "selected":""}}>{{ __('lang.closed') }}</option>
                                            <option value="{{ \App\Enum\ClientStatusEnum::LOST }}" {{ $client->latestStatus?->getRawOriginal('status') == \App\Enum\ClientStatusEnum::LOST? "selected":""}}>{{ __('lang.lost') }}</option>
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
                                            <option value="{{ $reason->id }}" {{ $reason->id == $client->latestStatus?->reason_id ? "selected":""}}>{{ $reason->name }}</option>
                                            @endforeach
                                        <select>
                                        @error('reason_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.date_time') }}</label>
                                        <input type="datetime-local" name="date_time" class="form-control" placeholder="{{ __('lang.date_time') }}" value="{{ $client->latestStatus?->date_time }}">
                                        @error('date_time')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <label>{{ __('lang.comment') }}</label>
                                        <textarea name="comment" class="form-control" placeholder="{{ __('lang.comment') }}">{{ $client->latestStatus?->comment }}</textarea>
                                        @error('comment')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            {{-- end update form --}}
                        </div>
                    </div>
                </div>
                {{-- end the client history --}}

                {{-- start the client services --}}
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('lang.client_services') }}</div>

                        <div class="card-body">
                            {{-- start update form --}}
                                <div class="row mb-3 g-3">
                                    
                                    @foreach ($services as $service)
                                        @if($client->services->contains('id', $service->id))
                                            <div class="client-service col-lg-3">
                                                <label>{{ $service->name }}</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text">
                                                    <input name="services[]" class="form-check-input mt-0" type="checkbox" value="{{ $service->id }}" checked>
                                                    </div>
                                                    <input name="prices[]" type="text" class="form-control" value="{{ $client->services->where('id', $service->id)->first()->pivot->price }}">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-3">
                                                <label>{{ $service->name }}</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text">
                                                    <input name="services[]" class="form-check-input mt-0" type="checkbox" value="{{ $service->id }}">
                                                    </div>
                                                    <input name="prices[]" type="text" class="form-control" aria-label="Text input with checkbox">
                                                </div>
                                            </div>
                                        @endif
                                                
                                    @endforeach
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.next_action') }} *</label>
                                        <select name="next_action" class="form-control">
                                            <option selected disabled>{{ __("lang.choose") }}</option>
                                            @if (count($client->services))
                                            <option value="{{ \App\Enum\ActionTypeEnum::CALL }}" {{ \App\Enum\ActionTypeEnum::CALL == $client->services->first()->pivot->next_action ? "selected":"" }}>{{ __('lang.call') }}</option>
                                            <option value="{{ \App\Enum\ActionTypeEnum::MEETING }}" {{ \App\Enum\ActionTypeEnum::MEETING == $client->services->first()->pivot->next_action ? "selected":"" }}>{{ __('lang.meeting') }}</option>
                                            <option value="{{ \App\Enum\ActionTypeEnum::WHATSAPP }}" {{ \App\Enum\ActionTypeEnum::WHATSAPP == $client->services->first()->pivot->next_action ? "selected":"" }}>{{ __('lang.whatsapp') }}</option>
                                            <option value="{{ \App\Enum\ActionTypeEnum::VISIT }}" {{ \App\Enum\ActionTypeEnum::VISIT == $client->services->first()->pivot->next_action ? "selected":"" }}>{{ __('lang.visit') }}</option>
                                            @else
                                            <option value="{{ \App\Enum\ActionTypeEnum::CALL }}">{{ __('lang.call') }}</option>
                                            <option value="{{ \App\Enum\ActionTypeEnum::MEETING }}">{{ __('lang.meeting') }}</option>
                                            <option value="{{ \App\Enum\ActionTypeEnum::WHATSAPP }}">{{ __('lang.whatsapp') }}</option>
                                            <option value="{{ \App\Enum\ActionTypeEnum::VISIT }}">{{ __('lang.visit') }}</option>
                                            @endif
                                            <select>
                                                @error('next_action')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.next_action_date') }} *</label>
                                        @if (count($client->services))
                                        <input type="datetime-local" value="{{ $client->services->first()->pivot->next_action_date }}" name="next_action_date" class="form-control">
                                        @else
                                        <input type="datetime-local" name="next_action_date" class="form-control">
                                        @endif
                                        @error('next_action_date')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <label>{{ __('lang.comment') }} *</label>
                                        @if (count($client->services))
                                        <textarea name="comment" class="form-control">{{ $client->services->first()->pivot->comment }}</textarea>
                                        @else
                                        <textarea name="comment" class="form-control"></textarea>
                                        @endif
                                        @error('comment')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>    
                                    
                                </div>
                            {{-- end update form --}}
                        </div>
                    </div>
                </div>
                {{-- end the client services --}}
                <div class="row mb-3 g-3">
                    <div class="">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> {{__('lang.update')}}</button>
                        <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{__('lang.go_back')}}</a>
                    </div>
                </div>
            </form>
        </div>
        @endsection
   
