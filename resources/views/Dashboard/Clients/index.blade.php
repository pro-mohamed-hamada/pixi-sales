@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.clients_filters') }}</div>

                    <div class="card-body">
                        
                        <div class="filters">
                            <div class="row mb-3 g-3">
                                <div class="col-lg-4">
                                    <label>fdfd</label>
                                    <input type="text" class="form-control" placeholder="First name" aria-label="First name">
                                </div>
                                <div class="col-lg-4">
                                    <label>fdfd</label>
                                    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
                                </div>
                            </div>
                        </div>
                        <div  class="filters-buttons">
                            <div class="">
                                <button class="btn btn-primary"><i class="fa fa-search"></i> {{__('lang.search')}}</button>
                                <button class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.reset')}}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            {{-- start Datatable --}}
            @include('Datatables.ClientsDatatable');
            {{-- end Datatable --}}
        </div>
        @endsection
        @section("script")
        @include('layouts.datatables-scripts')
        @endsection
