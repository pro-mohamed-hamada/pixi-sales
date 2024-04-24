@extends('layouts.app')


        @section('content')
        <div class="content col-md-9 col-lg-10 offset-md-3 offset-lg-2">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header">{{ __('lang.edit_user') }}</div>

                    <div class="card-body">
                        {{ session('message') }}
                        {{-- start update form --}}
                        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row mb-3 g-3">
                                
                                <div class="col-lg-4">
                                    <label>{{ __('lang.name') }} *</label>
                                    <input type="text" name="name" value="{{ old('name') ?? $user->name }}" class="form-control">
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.email') }} *</label>
                                    <input type="email" name="email" value="{{ old('email') ?? $user->email }}" class="form-control">
                                    @error('email')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.password') }}</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.password_confirmation') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                    @error('password')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4">
                                    <label>{{ __('lang.logo') }}</label>
                                    <input type="file" name="logo" class="form-control">
                                    @error('logo')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input name="is_active" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $user->getRawOriginal('is_active') ? "checked":"" }}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">{{ __('lang.is_active') }}</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3 g-3">
                                {{-- start the user targets --}}
                                <div class="mb-3  user-targets">
                                    <div class="mb-3">
                                        <button id="add-target" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.add_target')}}</button>
                                    </div>
                                    @foreach ($user->targets->where('created_at', '>=', \Carbon\Carbon::now()->subMonth()) as $user_target)
                                    <div class="mb-3 target">
                                        <div class="card">
                                            <div class="card-body">
                                                {{-- start update form --}}
                                                <div class="row mb-3 g-3">
                                                    <div class="col-lg-4">
                                                        <label>{{ __('lang.target') }} *</label>
                                                        <select name="userTargets_target[]" class="form-control">
                                                            <option>{{ __('lang.choose_one') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::VISIT }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::VISIT ? "selected":""}}>{{ __('lang.visit') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::PROPOSAL }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::PROPOSAL ? "selected":""}}>{{ __('lang.proposal') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::MEETING }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::MEETING ? "selected":""}}>{{ __('lang.meeting') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::CALL }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::CALL ? "selected":""}}>{{ __('lang.call') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::WHATSAPP_MESSAGE }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::WHATSAPP_MESSAGE ? "selected":""}}>{{ __('lang.whatsapp_message') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::CLIENT }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::CLIENT ? "selected":""}}>{{ __('lang.client') }}</option>
                                                            <option value="{{ \App\Enum\TargetsEnum::AMOUNT }}" {{ $user_target->getRawOriginal('target') ==  \App\Enum\TargetsEnum::AMOUNT ? "selected":""}}>{{ __('lang.amount') }}</option>
                                                        </select>
                                                        @error("userTargets_target[]")
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>{{ __('lang.target_value') }} *</label>
                                                        <input type="number" name="userTargets_target_value[]" value="{{ $user_target->target_value }}" class="form-control">
                                                        @error("userTargets_target_value[]")
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>{{ __('lang.target_done') }} *</label>
                                                        <input type="number" name="userTargets_target_done[]" value="{{ $user_target->target_done }}" class="form-control">
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
                                    @endforeach
                                </div>
                                {{-- end the user targets --}}
                            </div>
                            <div class="row mb-3 g-3">
                                {{-- start the user device serials --}}
                                <div class="mb-3  user-device-serials">
                                    <div class="mb-3">
                                        <button id="add-device-serial" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('lang.add_device_serial')}}</button>
                                    </div>
                                    @foreach ($user->deviceSerials as $device_serial)
                                    <div class="mb-3 device-serial">
                                        <div class="card">
                                            <div class="card-body">
                                                {{-- start update form --}}
                                                <div class="row mb-3 g-3">
                                                    <div class="col-lg-12">
                                                        <label>{{ __('lang.device_serial') }} *</label>
                                                        <input type="text" name="userDevices_device_serial[]" value="{{ $device_serial->device_serial }}" class="form-control">
                                                        @error("userDevices_device_serial[]")
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3 g-3">
                                                    <div class="device-serial-buttons">
                                                        <button type="button" class="btn btn-danger remove-device-serial"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                {{-- end update form --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {{-- end the user device serial --}}
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
                                    <option value="{{ \App\Enum\TargetsEnum::VISIT }}">{{ __('lang.visit') }}</option>
                                    <option value="{{ \App\Enum\TargetsEnum::PROPOSAL }}">{{ __('lang.proposal') }}</option>
                                    <option value="{{ \App\Enum\TargetsEnum::MEETING }}">{{ __('lang.meeting') }}</option>
                                    <option value="{{ \App\Enum\TargetsEnum::CALL }}">{{ __('lang.call') }}</option>
                                    <option value="{{ \App\Enum\TargetsEnum::WHATSAPP_MESSAGE }}">{{ __('lang.whatsapp_message') }}</option>
                                    <option value="{{ \App\Enum\TargetsEnum::CLIENT }}">{{ __('lang.client') }}</option>
                                    <option value="{{ \App\Enum\TargetsEnum::AMOUNT }}">{{ __('lang.amount') }}</option>
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
        {{-- start device serial --}}
        <div id="device-serial" style="display: none !important">
            <div class="mb-3 device-serial">
                <div class="card">
                    <div class="card-body">
                        {{-- start update form --}}
                        <div class="row mb-3 g-3">
                            <div class="col-lg-12">
                                <label>{{ __('lang.device_serial') }} *</label>
                                <input type="text" name="userDevices_device_serial[]" class="form-control">
                                @error("userDevices_device_serial[]")
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 g-3">
                            <div class="device-serial-buttons">
                                <button type="button" class="btn btn-danger remove-device-serial"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        {{-- end update form --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- end device serial --}}
        @section('script')
        <script>
            $(document).ready(function(){
                $('#add-target').click(function(){
                    var element = $('#target').html();
                    $('.user-targets').append(element);
                });
                $('.user-targets').on('click', '.remove-target', function(){
                    var element = $(this).parents('.target')
                    element.remove();
                });

                $('#add-device-serial').click(function(){
                    var element = $('#device-serial').html();
                    $('.user-device-serials').append(element);
                });
                $('.user-device-serials').on('click', '.remove-device-serial', function(){
                    var element = $(this).parents('.device-serial')
                    element.remove();
                });
            });
        </script>
        
        @endsection
           