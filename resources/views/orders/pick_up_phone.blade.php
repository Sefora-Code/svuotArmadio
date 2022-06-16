@extends('adminlte::page')

@section('title', 'Crea utente')

@section('css')
    
@stop


@section('content_header')
    <h1>Azioni da compiere quando si risponde al telefono</h1>
@stop

@section('content')
	<br><br>
    <form id="new-user-form" action="{{ route('users.store') }}" method="post" class="mb-0">
        {{ csrf_field() }}

		{{-- Header --}}
		
        <div class="row">
            <div class="col-3">
				<p><b>Cosa</b></p>            	
            </div>	
            <div class="col-5">
				<p><b>Script</b></p>            	
            </div>	
            <div class="col-4">
				<p><b>Cliente</b></p>            	
            </div>	            	
        </div>	


        <div class="row">
            <div class="col-3">
				<p>Presentazione</p>            	
            </div>	
            <div class="col-5">
            	<p>Buongiorno, servizio Lostello Porta a Porta, mi dica…</p>
            </div>	
            <div class="col-4">
            	
            </div>	
        </div>

        {{-- Name and Surname fields --}}
        <div class="row">
            <div class="col-3">
				<p>Nome e cognome</p>            	
            </div>	
            <div class="col-5">
            	<p>Mi dice il nome e il cognome?</p>
            </div>	
            <div class="col-4">
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
            </div>	
        </div>        
       
        {{-- more details --}}
        <div class="row">
            <div class="col-3">
				<p>Dettagli</p>            	
            </div>	
            <div class="col-5">
            	<p>Che nome è riportato sul campanello?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="text" name="more_details"
                           class="form-control "
                           value="" placeholder=""
                           autofocus/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-bell {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('more_details') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        

        {{-- notes --}}
        <div class="row">
            <div class="col-3">
				<p>Note</p>            	
            </div>	
            <div class="col-5">
            	<p>C'&egrave; bisogno che si salga al piano dove abita oppure ci consegnar&agrave; i sacchi fuori dal portone?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="text" name="more_details"
                           class="form-control "
                           value="" placeholder=""
                           autofocus/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-door-closed {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('more_details') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        

        {{-- address --}}
        <div class="row">
            <div class="col-3">
				<p>Indirizzo</p>            	
            </div>	
            <div class="col-5">
            	<p>Mi pu&ograve; dire l'indirizzo, via e numero civico?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="text" name="address"
                           class="form-control "
                           value="" placeholder=""
                           autofocus/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('address') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        

        {{-- telefono --}}
        <div class="row">
            <div class="col-3">
				<p>Telefono</p>            	
            </div>	
            <div class="col-5">
            	<p>il telefono dal quale chiama &egrave; quello che posso registrare?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="text" name="phone"
                           class="form-control "
                           value="" placeholder=""
                           autofocus/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('phone'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        

        {{-- Email field --}}
        <div class="row">
            <div class="col-3">
				<p>Email</p>            	
            </div>	
            <div class="col-5">
            	<p>mi pu&ograve; dire il suo indirizzo di posta elettronica?</p>
            </div>	
            <div class="col-4">
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
            </div>	
        </div>        

        {{-- simple info --}}
        <div class="row">
            <div class="col-3">
				<p>Informazioni al cliente sui sacchi</p>            	
            </div>	
            <div class="col-5">
            	<p>I vestiti vanno chiusi nei sacchi gialli della plastica</p>
            </div>	
            <div class="col-4">
            	
            </div>	
        </div>

        {{-- Volume --}}
        <div class="row">
            <div class="col-3">
				<p>Numero sacchi</p>            	
            </div>	
            <div class="col-5">
            	<p>Possiamo caricare fino a 5 sacchi, quanti sacchi ci consegnerebbe?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="email" name="volume"
                           class="form-control"
                           value="" placeholder=""/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-shopping-bag {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('volume'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('volume') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        
       
        {{-- simple info --}}
        <div class="row">
            <div class="col-3">
				<p>Info al cliente sugli orari</p>            	
            </div>	
            <div class="col-5">
            	<p>il ritiro avviene tra le 10:30 e le 11:45 da lunedì a venerdì</p>
            </div>	
            <div class="col-4">
            	
            </div>	
        </div>
       
        {{-- day --}}
        <div class="row">
            <div class="col-3">
				<p>Giorno</p>            	
            </div>	
            <div class="col-5">
            	<p>In che giorno preferisce che si effettui il ritiro?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="date" name="day"
                           class="form-control"
                           value="" placeholder=""/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('day'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('day') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        
        
        {{-- time --}}
        <div class="row">
            <div class="col-3">
				<p>Orario</p>            	
            </div>	
            <div class="col-5">
            	<p>In che orario preferisce che si effettui il ritiro?</p>
            </div>	
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="time" name="time"
                           class="form-control"
                           value="" placeholder=""/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-clock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('time'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('time') }}</strong>
                        </div>
                    @endif
                </div>
            </div>	
        </div>        

       
        {{-- simple info --}}
        <div class="row">
            <div class="col-3">
				<p>Rider</p>            	
            </div>	
            <div class="col-5">
            	<p></p>
            </div>	
            <div class="col-4">
            	<div class="input-group mb-3">
					<select class="mb-2 w-100" name="rider">
						<option selected></option>
                		@foreach($employees as $employee)
                			@if($employee->user && !strpos($employee->user->email, 'admin') && !strpos($employee->user->email, 'enotazioni'))
                    		<option value="{{$employee->id}}">
                    			{{$employee->user->name.' '.$employee->user->surname}}
                    		</option>
                    		@endif
                        @endforeach>
					</select>
				</div>
            </div>	
        </div>
       
<br><br>

        {{-- Register button --}}
        <button type="submit"
                id="btn-send"
                class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            Assegna ordine
        </button>
    </form>

@stop

@section('js')

@stop
