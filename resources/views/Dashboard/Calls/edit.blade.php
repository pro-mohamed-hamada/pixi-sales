@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_call') }}</div>

                    <div class="card-body">
                        {{-- start create form --}}
                        <form method="POST" action="{{ route('calls.update', $call->id) }}">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                <div class="col-lg-4">
                                    <label>{{ __('lang.client') }} *</label>
                                    <select name="client_id" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $call->client_id == $client->id ? "selected":"" }}>{{ $client->name }}</option>
                                        @endforeach
                                    <select>
                                    @error('client_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.type') }} *</label>
                                    <select name="type" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                            <option value="{{ \App\Enum\CallTypeEnum::INCOMING }}" {{ $call->getRawOriginal('type') == \App\Enum\CallTypeEnum::INCOMING ? "selected":"" }}>{{ __('lang.incoming') }}</option>
                                            <option value="{{ \App\Enum\CallTypeEnum::OUTGOING }}" {{ $call->getRawOriginal('type') == \App\Enum\CallTypeEnum::OUTGOING ? "selected":"" }}>{{ __('lang.outgoing') }}</option>
                                    <select>
                                    @error('type')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.date') }} *</label>
                                    <input type="datetime-local" name="date" value="{{ $call->date }}" class="form-control">
                                    @error('date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.status') }} *</label>
                                    <select name="status" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        <option value="{{ \App\Enum\CallStatusEnum::ANSWERED }}" {{ $call->getRawOriginal('status') == \App\Enum\CallStatusEnum::ANSWERED ? "selected":"" }}>{{ __('lang.answered') }}</option>
                                        <option value="{{ \App\Enum\CallStatusEnum::NOT_ANSWERED }}" {{ $call->getRawOriginal('status') == \App\Enum\CallStatusEnum::NOT_ANSWERED ? "selected":"" }}>{{ __('lang.not_answered') }}</option>
                                        <option value="{{ \App\Enum\CallStatusEnum::NOT_AVAILABLE }}" {{ $call->getRawOriginal('status') == \App\Enum\CallStatusEnum::NOT_AVAILABLE ? "selected":"" }}>{{ __('lang.not_available') }}</option>
                                        <option value="{{ \App\Enum\CallStatusEnum::PHONE_CLOSED }}" {{ $call->getRawOriginal('status') == \App\Enum\CallStatusEnum::PHONE_CLOSED ? "selected":"" }}>{{ __('lang.phone_closed') }}</option>
                                        <option value="{{ \App\Enum\CallStatusEnum::ERROR_NUMBER }}" {{ $call->getRawOriginal('status') == \App\Enum\CallStatusEnum::ERROR_NUMBER ? "selected":"" }}>{{ __('lang.error_number') }}</option>
                                    <select>
                                    @error('status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action') }} *</label>
                                    <select name="next_action" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::CALL }}" {{ \App\Enum\ActionTypeEnum::CALL == $call->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.call') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::MEETING }}" {{ \App\Enum\ActionTypeEnum::MEETING == $call->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.meeting') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::WHATSAPP }}" {{ \App\Enum\ActionTypeEnum::WHATSAPP == $call->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.whatsapp') }}</option>
                                        <option value="{{ \App\Enum\ActionTypeEnum::VISIT }}" {{ \App\Enum\ActionTypeEnum::VISIT == $call->getRawOriginal('next_action') ? "selected":"" }}>{{ __('lang.visit') }}</option>
                                        <select>
                                            @error('next_action')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.next_action_date') }} *</label>
                                    <input type="datetime-local" name="next_action_date" value="{{ $call->next_action_date }}" class="form-control">
                                    @error('next_action_date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label>{{ __('lang.comment') }} *</label>
                                    <textarea name="comment" class="form-control">{{ $call->comment }}</textarea>
                                    @error('comment')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {{__('lang.update')}}</button>
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
   
