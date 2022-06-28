
@php
	date_default_timezone_set('Europe/Rome');
	

    setlocale(LC_TIME, 'ita', 'it_IT.utf8');

@endphp
					
@extends('adminlte::page')

@section('title', 'Quando rispondi al telefono')

@section('css')

@stop


@section('content_header')
    <h1>Azioni da compiere quando si risponde al telefono</h1>
@stop

@section('content')
	<br><br>
    <form id="new-phone-order-form" action="{{ isset($newOrderDetail) ? route('update.phone.order') : route('store.phone.order') }}" method="post" class="mb-0">
        {{ csrf_field() }}
        
        @if (isset($newOrderDetail))
        <!-- in case we are editing an order, send the id of the order details -->
        <input type="hidden" name="order_details_id" value="{{$newOrderDetail->id}}" >
        
        @endif 

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
                           value="{{ old('name') ?? (isset($user) ? $user->name : '' ) }}" placeholder="{{ __('adminlte::adminlte.name') }}"
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
                           value="{{ old('surname') ?? (isset($user) ? $user->surname : '' ) }}" placeholder="{{ __('adminlte::adminlte.surname') }}"
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
                @php
                // get name on the ringbell (if any)
                if (isset($newOrderDetail))
                {
                    $ringName = substr($newOrderDetail->notes, strrpos($newOrderDetail->notes,'lo:')+3, strrpos($newOrderDetail->notes,'-') - strrpos($newOrderDetail->notes,'lo:') - 3); 
                }
                @endphp
                    <input type="text" name="more_details"
                           class="form-control "
                           value="{{ isset($ringName) ? $ringName : '' }}" placeholder="Nome sul campanello"
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
                 @php
                // get notes (if any)
                if (isset($newOrderDetail))
                {
                	$notes = substr(strrchr($newOrderDetail->notes,':'), 2); 
                }
                @endphp
                    <input type="text" name="more_details2"
                           class="form-control "
                           value="{{ isset($notes) ? $notes : '' }}" placeholder=""
                           autofocus/>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-door-closed {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('more_details2') }}</strong>
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
                           value="{{ old('address') ?? (isset($newOrderDetail) ? $newOrderDetail->shipping_address : '' ) }}" placeholder="Via e numero civico"
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
                    <input type="number" name="phone_number"
                           class="form-control "
                           value="{{ old('phone_number') ?? (isset($user) ? $user->phone_number : '' ) }}" placeholder="Numero di telefono senza spazi"
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
                           value="{{ old('email') ?? (isset($user) ? $user->email : '' ) }}" placeholder="{{ __('adminlte::adminlte.email') }}"/>
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
                    <input type="number" name="volume"
                           class="form-control" min="1" max="5"
                           value="{{ old('volume') ?? (isset($newOrderDetail) ? $newOrderDetail->volume : '' ) }}" placeholder="Numero sacchi da 1 a 5"/>
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
				<div id="date_block" class="row text-center mb-3">				
                    <div class="col-4" onclick="prevDay();" style="cursor:pointer; font-size:50px; padding-top: 20px;">
        				<i class="fas fa-arrow-left"></i>
                    </div>	
                    <div class="col-4" id="selectedDate" style="border: 1px solid #ccc; border-radius: 5px;">
    					<div id="dayName"></div>
    					<div id="day" style="font-size: 40px; margin: -15px 0;"></div>
    					<div id="month"></div>
    					<div id="year"></div>                    	
                    </div>	
                    <div class="col-4" onclick="nextDay();" style="cursor:pointer; font-size:50px; padding-top: 20px;">
                    	<i class="fas fa-arrow-right"></i>
					</div>
				</div>
                <input type="hidden" name="date" value="" id="dateInput" />
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
				<div id="date_block" class="row text-center mb-3">				
                    <div class="col-4" onclick="prevTime();" style="cursor:pointer; font-size:50px;">
        				<i class="fas fa-arrow-left"></i>
                    </div>	
                    <div class="col-4 mt-2" id="selectedTime" style="border: 1px solid #ccc; border-radius: 5px;">
    					<div id="time" style="font-size: 40px;"></div>
                    </div>	
                    <div class="col-4" onclick="nextTime();" style="cursor:pointer; font-size:50px;">
                    	<i class="fas fa-arrow-right"></i>
					</div>
				</div>
                <input type="hidden" name="time" value="" id="hourInput" />
            </div>	
        </div>        

       
        {{-- rider --}}
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
                    		<option value="{{$employee->id}}"
                    			@if(isset($newOrder) && $newOrder->assigned_to == $employee->id)
                    				selected
        						@endif                    		
                    		>
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
        <button type="submit" id="submitBtn"
                id="btn-send"
                class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            Assegna ordine
        </button>
        <input type="hidden" name="password" value="12345678" />
        <input type="hidden" name="password_confirmation" value="12345678" />
        <input type="hidden" name="type" value="customer" />
    </form>


@include('orders.calendar')


@stop


@section('js')
<script>

	var daysName = ["Domenica", "Luned&igrave;","Marted&igrave;", "Mercoled&igrave;", "Gioved&igrave;", "Venerd&igrave;", "Sabato"];
	var timeSlots = ['10:15','10:30','10:45','11:00','11:15','11:30'];
	var chosenDate = new Date();
	var chosenTime = 0;

	// in case we are loading an order, prepopulate chosen date and chosen time
    @if (isset($newOrderDetail))
        // set the date
    	@php
    	$datetime = DateTime::createFromFormat('Y-m-d H:i:s', $newOrderDetail->pickup_date);
		@endphp
        chosenDate.setFullYear({{ $datetime->format('Y') }},{{ $datetime->format('m') }}-1,{{ $datetime->format('d') }});

        // set the time
        for (let i=0; i<timeSlots.length; i++)
        {
            if (timeSlots[i] == '{{ $newOrderDetail->time_frame }}')
                chosenTime = i;
        }
        
	@endif
	
	showDate();
	verifyBankHoliday(chosenDate);
	showTime();
	verifyAvailability();

	populateCalendar(); // to populate the bottom calendar -> see calendar.blade.php for details 
		
	function showDate()
	{    
     	document.getElementById("day").innerHTML = chosenDate.getDate();
     	document.getElementById("month").innerHTML = getItMonth(chosenDate.getMonth());
     	document.getElementById("dayName").innerHTML = daysName[chosenDate.getDay()];
     	document.getElementById("year").innerHTML = chosenDate.getFullYear();
	}
 	
	function getItMonth(month)
	{
		if (month == 0) return "Gennaio";
		if (month == 1) return "Febbraio";
		if (month == 2) return "Marzo";
		if (month == 3) return "Aprile";
		if (month == 4) return "Maggio";
		if (month == 5) return "Giugno";
		if (month == 6) return "Luglio";
		if (month == 7) return "Agosto";
		if (month == 8) return "Settembre";
		if (month == 9) return "Ottobre";
		if (month == 10) return "Novembre";
		if (month == 11) return "Dicembre";
	}

	function showTime()
	{    
     	document.getElementById("time").innerHTML = timeSlots[chosenTime];
	}

	function prevDay()
	{
		chosenDate.setDate(chosenDate.getDate()-1);
		showDate();
		verifyBankHoliday(chosenDate);
	}

	function nextDay()
	{
		chosenDate.setDate(chosenDate.getDate()+1);
		showDate();
		verifyBankHoliday(chosenDate);
	}

	function verifyBankHoliday(dateToCheck)
	{
		if (dateToCheck.getDay() == 0 || dateToCheck.getDay() == 6) // saturday or sunday
		{
			document.getElementById("selectedDate").style.background = "#ff8f8f";
	    	document.getElementById("dateInput").value = "";
		    evaluateForm();
		}
		else // check on server
		{
    		let formattedDate = dateToCheck.getFullYear()+"-"+(dateToCheck.getMonth()+1)+"-"+dateToCheck.getDate();
    		fetch("{{ route('is_bank_holiday') }}?d="+formattedDate, {method: 'GET' })
        	.then(res => res.text())
    	    .then(response =>
    	    {
    		    if (response == "-1") // working day
    		    {
    		    	document.getElementById("selectedDate").style.background = "#a5f7a6";
    		    	document.getElementById("dateInput").value = formattedDate;
    		    	verifyAvailability();
    		    }
    		    else
    		    {
    		    	document.getElementById("selectedDate").style.background = "#ff8f8f";
    		    	document.getElementById("dateInput").value = "";
    		    }
    		    evaluateForm();
    	    })
            .catch((error) => alert("Errore nel reperire il giorno festivo: "+ error));
		}
	}


	function prevTime()
	{
		if (chosenTime == 0) return; // stop there
		
		chosenTime--;
		showTime();
		verifyAvailability();
	}

	function nextTime()
	{
		if (chosenTime == 5) return; // stop there
		
		chosenTime++;
		showTime();
		verifyAvailability();
	}

	function verifyAvailability()
	{
		if (document.getElementById("dateInput").value != "")
		{
			let formattedDate = chosenDate.getFullYear()+"-"+(chosenDate.getMonth()+1)+"-"+chosenDate.getDate();
			let timeslot = timeSlots[chosenTime].replace(":", "|"); // replace the colon here - but need to do the opposite on the server
    		fetch("{{ route('timeslot_available') }}?d="+formattedDate+"&t="+timeslot, {method: 'GET' })
        	.then(res => res.text())
    	    .then(response =>
    	    {
    		    if (response == "-1") // time slot available
    		    {
    		    	document.getElementById("selectedTime").style.background = "#a5f7a6";
    		    	document.getElementById("hourInput").value = timeSlots[chosenTime];
    		    }
    		    else
    		    {
    		    	document.getElementById("selectedTime").style.background = "#ff8f8f";
    		    	document.getElementById("hourInput").value = "";
    		    }
    		    evaluateForm();
    	    })
            .catch((error) => alert("Errore nel reperire il ordini per quell'orario: "+ error));
		}
		else
		{
	    	document.getElementById("selectedTime").style.background = "#ff8f8f";
	    	document.getElementById("hourInput").value = "";
		}
		
	 	evaluateForm();
	}
	

	
	function evaluateForm()
	{
		let d = document.getElementById("dateInput").value;
		let h = document.getElementById("hourInput").value;
		if (d != "" && h != "")
			document.getElementById("submitBtn").disabled = false;
		else
			document.getElementById("submitBtn").disabled = true;
	}
	
</script>
@stop
