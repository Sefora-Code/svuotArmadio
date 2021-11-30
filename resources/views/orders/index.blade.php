@extends('adminlte::page')

@section('title', 'Ordini')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@stop


@section('content_header')
    <h1>Ordini</h1>
@stop

@section('content')

<table id="ordersTable" class="display">
    <thead>
        <tr>
            <th>Ciente</th>
            <th>Stato</th>
            <th>Indirizzo</th>
            <th>Volume</th>
            <th>Data ritiro</th>
            <th>Creato il</th>
            <th>Assegnato a</th>
            <th>Note</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
		@foreach($orders as $order)
        	<tr>
				<td>{{ $order->customer->user->name }} {{ $order->customer->user->surname }}</td>
				<td>{{ $order->fullfilled }}</td>
				<td>{{ $order->customer->address }}</td>
				<td>{{ $order->orderDetails->volume }}</td>
				<td>{{ $order->orderDetails->pickup_date }}</td>
				<td>{{ $order->created_at }}</td>
				<td>{{ $order->employee ? $order->employee->user->name.' '.$order->employee->user->surname : '-'}}</td>
				<td>{{ $order->orderDetails->notes }}</td>
				<td>
					<button class="btn btn-flat" onclick="showAssignEmployee(this)">Assegna</button>
					<span class="d-none">
    					<select>
    						<option></option>
                    		@foreach($employees as $employee)
                        		<option value="{{$employee->id}}">
                        			{{$employee->user->name.' '.$employee->user->surname}}
                        		</option>
                            @endforeach>
    					</select>
						<button class="btn" onclick="confirmEmployee(this, '{{$order->id}}')">Conferma</button>
					</span>
					<button class="btn" onclick="accept('{{$order->id}}')">Accetta</button>
					<button class="btn" onclick="reject('{{$order->id}}')">Rifiuta</button>
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
