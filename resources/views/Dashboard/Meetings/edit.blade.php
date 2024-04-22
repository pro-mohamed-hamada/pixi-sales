@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.edit_meeting') }}</div>

                    <div class="card-body">
                        {{-- start create form --}}
                        <form method="POST" action="{{ route('meetings.update', $meeting->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-4">
                                    <label>{{ __('lang.client') }} *</label>
                                    <select name="client_id" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $meeting->client_id == $client->id ? "selected":"" }}>{{ $client->name }}</option>
                                        @endforeach
                                    <select>
                                    @error('client_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.date') }} *</label>
                                    <input type="datetime-local" name="date" value="{{ $meeting->date }}" class="form-control">
                                    @error('date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action') }} *</label>
                                    <select name="next_action" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::CALL }}" {{ \App\Enum\ActionTypeEnum::CALL == $meeting->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.call') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::MEETING }}" {{ \App\Enum\ActionTypeEnum::MEETING == $meeting->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.meeting') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::WHATSAPP }}" {{ \App\Enum\ActionTypeEnum::WHATSAPP == $meeting->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.whatsapp') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::VISIT }}" {{ \App\Enum\ActionTypeEnum::VISIT == $meeting->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.visit') }}</option>
                                        <select>
                                            @error('next_action')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action_date') }} *</label>
                                    <input type="datetime-local" name="next_action_date" value="{{ $meeting->next_action_date }}" class="form-control">
                                    @error('next_action_date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.person_position') }} *</label>
                                    <input type="text" name="person_position" value="{{ $meeting->person_position }}" class="form-control">
                                    @error('person_position')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>{{ __('lang.comment') }} *</label>
                                    <textarea name="comment" class="form-control">{{ $meeting->comment }}</textarea>
                                    @error('comment')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> {{__('lang.update')}}</button>
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
   
