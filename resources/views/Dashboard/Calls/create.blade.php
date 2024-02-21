@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_call') }}</div>

                    <div class="card-body">
                        {{-- start create form --}}
                        <form method="POST" action="{{ route('calls.store') }}">
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
                                    <label>{{ __('lang.type') }} *</label>
                                    <select name="type" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ \App\Enum\CallTypeEnum::INCOMING }}">{{ __('lang.incoming') }}</option>
                                            <option value="{{ \App\Enum\CallTypeEnum::OUTGOING }}">{{ __('lang.outgoing') }}</option>
                                        @endforeach
                                    <select>
                                    @error('type')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.date') }} *</label>
                                    <input type="datetime-local" name="date" class="form-control">
                                    @error('date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.status') }} *</label>
                                    <select name="status" class="form-control">
                                        <option selected disabled>{{ __("lang.choose") }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ \App\Enum\CallStatusEnum::ANSWERED }}">{{ __('lang.answered') }}</option>
                                        @endforeach
                                    <select>
                                    @error('status')
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
                                <div class="col-lg-6">
                                    <label>{{ __('lang.next_action_note') }} *</label>
                                    <textarea name="next_action_note" class="form-control"></textarea>
                                    @error('next_action_note')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>{{ __('lang.comment') }} *</label>
                                    <textarea name="comment" class="form-control"></textarea>
                                    @error('comment')
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
   
