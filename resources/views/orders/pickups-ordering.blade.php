@extends('adminlte::page')

@section('title', 'Ordini')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@stop


@section('content_header')
    <h1 class="mb-5">Ordinamento ritiri del {{date('d/m/Y')}} assegnati a {{$user->name.' '.$user->surname}}</h1>
@stop

@section('content')

<table id="ordersTable" class="display mt-5">
    <thead>
        <tr>
            <th>Ciente</th>
            <th>Stato</th>
            <th>Indirizzo</th>
            <th>Volume</th>
            <th>Note</th>
            <th>Ordinamento</th>
        </tr>
    </thead>
    <tbody>
		@foreach($orders as $order)
			@if($order->orderDetails->pickup_date == date('Y-m-d 00:00:00') && $order->fullfilled < 4)
        	<tr>
				<td>{{ $order->customer->user->name }} {{ $order->customer->user->surname }}</td>
				<td>
				@switch($order->fullfilled)
					@case(0)
						Registrato
						@break
					@case(1)
						Approvato
						@break 
					@case(2)
						Rifiutato
						@break
					@case(3)
						Assegnato al rider
						@break
					@case(4)
						Completato
						@break
					@case(5)
						Non si riesce a completare
						@break
				@endswitch
				</td>
				<td>{{ $order->orderDetails->shipping_address }}</td>
				<td>
				@switch($order->orderDetails->volume)
					@case(2)
						1 - 2 Sacchetti
						@break
					@case(4)
						2 - 4 Sacchetti
						@break 
				@endswitch
				</td>
				<td>{{ $order->orderDetails->notes }}</td>
				<td>
					<input type="number" class="ordering-inputs" name="{{$order->id}}" value="" oninput="checkPositive(this)">
					<!-- button class="btn btn-success mb-2" onclick="accept('{{$order->id}}')">Accetta</button>
					<button class="btn btn-warning mb-2" onclick="reject('{{$order->id}}')">Rifiuta</button-->
				</td>
	        </tr>
        	@endif
        @endforeach
    </tbody>
</table>
    
<div class="row mt-4">
	<div class="col-12 text-center">
		<button class="btn btn-success w-25" onclick="confrmOrder()">Conferma ordinamento ritiri</button>
	</div>
</div>

@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script> 

    $(document).ready(function() 
    {
        $('#ordersTable').DataTable();
    });

    function checkPositive(thisInput)
    {
        if (isNaN(thisInput.value) || thisInput.value < 1)
        {
            alert("Si possono accettare solo numeri maggiori di 0");
            thisInput.value = "";
        }
    }
    
    function confrmOrder()
    {
        // 1 firstly check the sequence
        // 1.1 are there any holes?
		var inputs = document.getElementsByClassName("ordering-inputs");

		let inputValues = []; 
		let inputSum = 0;
		let indexSum = 0;
		for (let i=0; i < inputs.length; i++)
		{
			inputSum += new Number(inputs[i].value);
			indexSum += (i+1);

			inputValues.push({id: inputs[i].name, order: inputs[i].value});
		}

		console.log(inputValues);

		if (inputSum != indexSum)
		{
			alert("Gli ordini non sono stati messi tutti in sequenza.");
			return;
		} 

        		
    	const url = '{{route('pickups.ordering.confirm')}}';
        const data = {orders : inputValues};
        const headers = {'X-CSRF-TOKEN': '{{csrf_token()}}', 'Content-Type': 'application/json'}
        
    	fetch(url, {
        	method: 'POST', 
    	    headers: headers,
        	body: JSON.stringify(data)
    		})
          .then(response => response.json())
          .then(data => {
          	if (data.code != 200)
          		alert(data);
      		else
      			location.reload(true);
          });
    }
    
</script>    
@stop
