@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.fcm_messages_filters') }}</div>

                    <div class="card-body">
                        <form class="datatables_parameters">
                            <div class="filters">
                                <div class="row mb-3 g-3">
                                    <div class="col-lg-4">
                                        <label>{{ __('lang.is_active') }}</label>
                                        <select name="is_active" class="form-control">
                                            <option value="">{{ __('lang.choose') }}</option>
                                            <option value="{{ \App\Enum\ActivationStatusEnum::ACTIVE }}">{{ __('lang.active') }}</option>
                                            <option value="{{ \App\Enum\ActivationStatusEnum::NOT_ACTIVE }}">{{ __('lang.not_active') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div  class="filters-buttons">
                                <div class="">
                                    <button class="search_datatable btn btn-primary"><i class="fa fa-search"></i> {{__('lang.search')}}</button>
                                    <button class="reset_form_data btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.reset')}}</button>
                                </div>
                            </div>
                        </form>
                        

                    </div>
                </div>
            </div>
            
            {{-- start Datatable --}}
            @include('Datatables.FcmMessagesDatatable');
            {{-- end Datatable --}}
        </div>
        @endsection
        @section("script")
        @include('layouts.datatables-scripts')
        @endsection
