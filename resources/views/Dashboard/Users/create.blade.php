@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.create_user') }}</div>

                    <div class="card-body">
                        {{ session('message') }}
                        {{-- start create form --}}
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="row mb-3 g-3">
                                
                                <div class="col-lg-4">
                                    <label>{{ __('lang.name') }} *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.email') }} *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                    @error('email')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.password') }} *</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.password_confirmation') }} *</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                    @error('password')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input name="is_active" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">{{ __('lang.is_active') }}</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3 g-3">
                                {{-- start the client targets --}}
                                <div class="mb-3  client-targets">
                                    <div class="mb-3">
                                        <button id="add-target" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.add_target')}}</button>
                                    </div>
                                </div>
                                {{-- end the client targets --}}
                            </div>
                            <div class="row mb-3 g-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.create')}}</button>
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
   
        <div id="target" style="display: none !important">
            <div class="mb-3 target">
                <div class="card">
                    <div class="card-body">
                        {{-- start update form --}}
                        <div class="row mb-3 g-3">
                            <div class="col-lg-4">
                                <label>{{ __('lang.target') }} *</label>
                                <select name="userTargets_target[]" class="form-control">
                                    <option>{{ __('lang.choose_one') }}</option>
                                    @foreach ($targets as $target)
                                        <option value="{{ $target->id }}">{{ $target->name }}</option>
                                    @endforeach
                                </select>
                                @error("userTargets_target[]")
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('lang.target_value') }} *</label>
                                <input type="number" name="userTargets_target_value[]" class="form-control">
                                @error("userTargets_target_value[]")
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('lang.target_done') }} *</label>
                                <input type="number" name="userTargets_target_done[]" class="form-control">
                                @error("userTargets_target_done[]")
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 g-3">
                            <div class="target-buttons">
                                <button type="button" class="btn btn-danger remove-target"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        {{-- end update form --}}
                    </div>
                </div>
            </div>
        </div>
        @section('script')
        <script>
            $(document).ready(function(){
                $('#add-target').click(function(){
                    var element = $('#target').html();
                    $('.client-targets').append(element);
                });
                $('.client-targets').on('click', '.remove-target', function(){
                    var element = $(this).parents('.target')
                    element.remove();
                });
            });
        </script>
        
        @endsection
           