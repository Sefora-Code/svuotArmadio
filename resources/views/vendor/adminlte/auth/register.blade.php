@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @section('auth_header', __('adminlte::adminlte.register_message'))

            @section('auth_body')
                <form id="registration-form" action="{{ $register_url }}" method="post" class="mb-0">
                    {{ csrf_field() }}

                    {{-- Name field --}}
                    <div class="input-group mb-3">
                        <input type="text" name="name"
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name') ?? '' }}" placeholder="{{ __('adminlte::adminlte.name') }}"
                               autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Surname field --}}
                    <div class="input-group mb-3">
                        <input type="text" name="surname"
                               class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}"
                               value="{{ old('surname') ?? '' }}" placeholder="{{ __('adminlte::adminlte.surname') }}"
                               autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('surname'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('surname') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Email field --}}
                    <div class="input-group mb-3">
                        <input type="email" name="email"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') ?? '' }}" placeholder="{{ __('adminlte::adminlte.email') }}"/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Password field --}}
                    <div class="input-group mb-3">
                        <input type="password" name="password"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="{{ __('adminlte::adminlte.password') }}"/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Confirm password field --}}
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation"
                               class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                               placeholder="{{ __('adminlte::adminlte.retype_password') }}"/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('password_confirmation'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Phone number field --}}
                    <div class="input-group mb-3">
                        <input type="text" name="phone_number"
                               class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
                               value="{{ old('phone_number') ?? '' }}"
                               placeholder="{{ __('adminlte::adminlte.phone_number') }}"
                               autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('phone_number'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Address field --}}
                    <div class="input-group mb-3">
                        <input type="text" name="address"
                               class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                               value="{{ old('address') ?? '' }}" placeholder="{{ __('adminlte::adminlte.address') }}"
                               autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-marker {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Type of user --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">
                            {{ __('adminlte::adminlte.type') }}
                        </h4>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radio-one" name="type" class="custom-control-input"
                                   value="customer" {{old('user_type') == 'customer' ? 'checked' : ''}}/>
                            <label class="custom-control-label" for="radio-one">
                                Cliente
                            </label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radio-two" name="type" class="custom-control-input"
                                   value="deliverer" {{old('user_type') == 'deliverer' ? 'checked' : ''}}/>
                            <label class="custom-control-label" for="radio-two">
                                Fattorino
                            </label>
                        </div>
                    </div>

                    {{-- Register button --}}
                    <button type="button"
                            id="btn-send"
                            class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                        <span class="fas fa-user-plus"></span>
                        {{ __('adminlte::adminlte.register') }}
                    </button>
                </form>
            @stop

            @section('auth_footer')
                <p class="my-0">
                    <a href="{{ $login_url }}">
                        {{ __('adminlte::adminlte.i_already_have_a_membership') }}
                    </a>
                </p>
            @stop
        </div>
    </div>
</div>

@section('js')
    <script>
        $(document).ready(function () {
            $('#btn-send').click(function () {
                let radioOne = $('#radio-one').is(':checked');

                let radioTwo = $('#radio-two').is(':checked');

                if (!radioOne && !radioTwo) {
                    alert('Devi scegliere una delle due opzioni tra "Cliente" e "Fattorino"!');
                } else {
                    $('#registration-form').submit();
                }
            });
        });
    </script>
@endsection
