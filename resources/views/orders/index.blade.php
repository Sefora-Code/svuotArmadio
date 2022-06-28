@extends('adminlte::page')

@section('title', 'Ordini')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <style>
    .dt-button{margin-bottom: 20px;}
    </style>
@stop


@section('content_header')
    <h1>Ritiri</h1>
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
			    	<span class="input-group-text" id="address">Indirizzo</span>
			  	</div>
			  	<input type="text" name="shipping_address" aria-describedby="address" class="form-control" placeholder="lasciare vuoto se uguale all'indirizzo del cliente"/>
			</div>
			
			<div class="input-group mb-3">
				<div class="input-group-prepend">
			    	<span class="input-group-text" id="volumeLabel">Quantit&agrave;</span>
			  	</div>
			  	<input type="number" class="form-control" name="volume" aria-describedby="volumeLabel" placeholder="Numero sacchi da 1 a 5" min="1" max="5" required>
			</div>
		
		
			<div class="input-group mb-3">
				<div class="input-group-prepend">
			    	<span class="input-group-text" id="basic-addon3">Data ritiro</span>
			  	</div>
			  	<input type="date" class="form-control" name="date" aria-describedby="basic-addon3" required>
			</div>
		
			<div class="input-group mb-3">
				<div class="input-group-prepend">
			    	<span class="input-group-text" id="basic-addon4">Fascia oraria</span>
			  	</div>
			  	<select class="form-control" name="time" aria-describedby="basic-addon4" required>
			  		<option value="10:15">10:15</option>
			  		<option value="10:30">10:30</option>
			  		<option value="10:45">10:45</option>
			  		<option value="11:00">11:00</option>
			  		<option value="11:15">11:15</option>
			  		<option value="11:30">11:30</option>
			  	</select>
			</div>
		
		
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text">Note</span>
			  </div>
			  <textarea name="notes" class="form-control" aria-label="Note"></textarea>
			</div>

			@csrf
			<button class="btn btn-success">Salva ordine</button>
		
		</form>
	</div>
</div>




<table id="ordersTable" class="display">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Stato</th>
            <th>Assegnato a</th>
            <th>Indirizzo</th>
            <th>Quantit&agrave;</th>
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
				@switch($order->status)
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
				<td>{{ $order->employee ? $order->employee->user->name.' '.$order->employee->user->surname : '-'}}</td>
				<td>{{ $order->orderDetails->shipping_address }}</td>
				<td>
				{{ $order->orderDetails->volume }} sacchetti
				{{--
				@switch($order->orderDetails->volume)
					@case(1)
					@case(2)
						1 - 2 Sacchetti
						@break
					@case(3)
					@case(4)
						2 - 4 Sacchetti
						@break 
				@endswitch
				--}}
				</td>
				<td>{{ date("d/m/Y", strtotime($order->orderDetails->pickup_date)) }}</td>
				<td>{{ $order->created_at }}</td>
				<td>{{ $order->orderDetails->notes }}</td>
				<td>
				@if($order->status == 0)
					<button class="btn btn-success mb-2" onclick="accept('{{$order->id}}')">Accetta</button>
					<button class="btn btn-warning mb-2" onclick="reject('{{$order->id}}')">Rifiuta</button>
				@elseif($order->status == 1)
					<button class="btn btn-info mb-2" onclick="showAssignEmployee(this)">Assegna</button>
					<span class="d-none">
    					<select class="mb-2">
    						<option selected></option>
                    		@foreach($employees as $employee)
                    			@if($employee->user && !strpos($employee->user->email, 'admin') && !strpos($employee->user->email, 'enotazioni'))
                        		<option value="{{$employee->id}}">
                        			{{$employee->user->name.' '.$employee->user->surname}}
                        		</option>
                        		@endif
                            @endforeach>
    					</select>
						<button class="btn btn-success" onclick="confirmEmployee(this, '{{$order->id}}')">Conferma</button>
					</span>
				@endif
				@if($order->status < 4)
					<button class="btn btn-primary mb-2" onclick="window.location.href='{{route('edit.phone.order', $order->orderDetails->id) }}'">Modifica</button>
				@endif
				</td>
	        </tr>
        @endforeach
    </tbody>
</table>
<br><br>    


@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/fh-3.2.0/datatables.min.js"></script>
<script> 

    $(document).ready(function() 
    {
        $('#ordersTable').DataTable({
            dom: 'Blfrtip',
            "order": [[ 5, 'desc' ]],
            buttons: [
//                 'csv',
                'excel',
                {
                    extend: 'pdf',
                	orientation: 'landscape',
            	    customize: function(doc) {
            	    	doc.styles.tableHeader.fontSize = 7
            	    	doc.defaultStyle.fontSize = 7;
            	    }
                },
//                 'print'
            ],
            language: {
                search: 		"Cerca nella tabella:",
                lengthMenu: "Mostra _MENU_ righe",
                info:       "Mostro da _START_ a _END_ su _TOTAL_ ordini",
        				paginate: {
                    first:      "Primo",
                    previous:   "Precedente",
                    next:       "Prossimo",
                    last:       "Ultimo"
                },
        			}
        });
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
