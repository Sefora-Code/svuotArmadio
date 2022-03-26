@extends('adminlte::page')

@section('title', 'Ordini')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@stop


@section('content_header')
    <h1>Ordini</h1>
@stop

@section('content')

<div class="text-right mb-4 p-3" style="background-color: white;">
	<button class="btn btn-primary" onclick="showOrderUI();">Inserisci nuovo ordine</button>

	<div id="addOrder" class="mt-2 text-left d-none">
		<form method="post" action="{{route('store.order')}}">
			<div class="input-group mb-3">
			
		  		<div class="input-group-prepend">
		    		<label class="input-group-text" for="userSelect">Cliente</label>
		  		</div>
		  		<select class="custom-select" id="userSelect" aria-label="userSelect" name="customer" required>
				    <option selected></option>
               		@foreach($customers as $customer)
                   		<option value="{{$customer->id}}">
                   			{{$customer->user->name.' '.$customer->user->surname}}
                   		</option>
                    @endforeach>
		  		</select>
			</div>
		
			<div class="input-group mb-3">
				<div class="input-group-prepend">
			    	<span class="input-group-text" id="volumeLabel">Volume</span>
			  	</div>
			  	<input type="number" class="form-control" name="volume" aria-describedby="volumeLabel" placeholder="solo valori interi" required>
			</div>
		
		
			<div class="input-group mb-3">
				<div class="input-group-prepend">
			    	<span class="input-group-text" id="basic-addon3">Data ritiro</span>
			  	</div>
			  	<input type="date" class="form-control" name="date" aria-describedby="basic-addon3" required>
			</div>
		
		
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text">Note</span>
			  </div>
			  <textarea class="form-control" aria-label="Note"></textarea>
			</div>

			@csrf
			<button class="btn btn-success">Salva ordine</button>
		
		</form>
	</div>
</div>




<table id="ordersTable" class="display">
    <thead>
        <tr>
            <th>Ciente</th>
            <th>Stato</th>
            <th>Indirizzo</th>
            <th>Volume</th>
            <th>Assegnato a</th>
            <th>Data ritiro</th>
            <th>Creato il</th>
            <th>Note</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
		@foreach($orders as $order)
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
				<td>{{ $order->employee ? $order->employee->user->name.' '.$order->employee->user->surname : '-'}}</td>
				<td>{{ $order->orderDetails->pickup_date }}</td>
				<td>{{ $order->created_at }}</td>
				<td>{{ $order->orderDetails->notes }}</td>
				<td>
					<button class="btn btn-success mb-2" onclick="accept('{{$order->id}}')">Accetta</button>
					<button class="btn btn-warning mb-2" onclick="reject('{{$order->id}}')">Rifiuta</button>
					<button class="btn btn-info mb-2" onclick="showAssignEmployee(this)">Assegna</button>
					<span class="d-none">
    					<select class="mb-2">
    						<option selected></option>
                    		@foreach($employees as $employee)
                        		<option value="{{$employee->id}}">
                        			{{$employee->user->name.' '.$employee->user->surname}}
                        		</option>
                            @endforeach>
    					</select>
						<button class="btn btn-success" onclick="confirmEmployee(this, '{{$order->id}}')">Conferma</button>
					</span>
				</td>
	        </tr>
        @endforeach
    </tbody>
</table>
    


@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script> 

    $(document).ready(function() 
    {
        $('#ordersTable').DataTable();
    });
    
    function showOrderUI()
    {
    	$("#addOrder").removeClass("d-none");
    }
    
    function showAssignEmployee(element)
    {
    	$(element).next('span').removeClass('d-none');
    }
    function confirmEmployee(element, orderId)
    {
    	const employeeId = $(element).parent().find('select').val();
    	
    	const url = '{{route('order.assign')}}';
        const data = {orderId : orderId, employeeId: employeeId};
        const headers = {'X-CSRF-TOKEN': '{{csrf_token()}}', 'Content-Type': 'application/json'}
        
    	fetch(url, {
        	method: 'POST', 
    	    headers: headers,
        	body: JSON.stringify(data)
    		})
          .then(response => response.json())
          .then(data => {
          	if (data.error != "")
          		alert(data);
      		else
      			location.reload(true);
          });
    }
    
    function accept(orderId)
    {
    	const url = '{{route('order.accept')}}';
        const data = {orderId : orderId};
        const headers = {'X-CSRF-TOKEN': '{{csrf_token()}}', 'Content-Type': 'application/json'}
        
    	fetch(url, {
        	method: 'POST', 
    	    headers: headers,
        	body: JSON.stringify(data)
    		})
          .then(response => response.json())
          .then(data => {
          	if (data.error != "")
          		alert(data);
      		else
      			location.reload(true);
          });
	}    
	
    function reject(orderId)
    {
    	const url = '{{route('order.reject')}}';
        const data = {orderId : orderId};
        const headers = {'X-CSRF-TOKEN': '{{csrf_token()}}', 'Content-Type': 'application/json'}
        console.log(data)
    	fetch(url, {
        	method: 'POST', 
    	    headers: headers,
        	body: JSON.stringify(data)
    		})
          .then(response => response.json())
          .then(data => {
          	if (data.error != "")
          		alert(data);
      		else
      			location.reload(true);
          });
	}
	
</script>    
@stop
