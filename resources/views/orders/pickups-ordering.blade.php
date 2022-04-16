@extends('adminlte::page')

@section('title', 'Ordini')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

	<!-- use Leaflet library to load map and marker https://leafletjs.com -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
   
    <style>
    /* use viewport-relative units to cover page fully */
    
    #map {
        height: 600px;
        width: 100%;
    }
    </style>
    
	<!-- use Leaflet library to load map and marker https://leafletjs.com -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

@endsection	

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
            <th>Mostra sulla mappa</th>
        </tr>
    </thead>
    <tbody>
		@foreach($orders as $order)
			@if($order->orderDetails->pickup_date == date('Y-m-d 00:00:00') && $order->status < 4)
        	<tr id="order_{{$order->id}}">
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
					<input type="number" class="ordering-inputs" name="{{$order->id}}" value="{{$order->seq_number}}" oninput="checkPositive(this)">
					<!-- button class="btn btn-success mb-2" onclick="accept('{{$order->id}}')">Accetta</button>
					<button class="btn btn-warning mb-2" onclick="reject('{{$order->id}}')">Rifiuta</button-->
				</td>
				<td>
					<button class="btn btn-info" onclick="showOnMap({{$order->id}})">Mostra</button>
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

<div class="row mt-4">
	<div class="col-12">
		<div class="title mb-3 text-center"><h1>Mappa</h1></div>

		<div id="map" ></div>
	
        <!-- Modal -->
        <div class="modal fade" id="waitModal" tabindex="-1" aria-labelledby="waitModalLabel" aria-hidden="true" style="margin-top: 10rem;">
        	<div class="modal-dialog">
        		<div class="modal-content" style="background-color: transparent; border: 0 none;">
        			<div class="modal-body" style="text-align: center;font-size: 20rem;">
						<i class="fas fa-cog fa-spin"></i>
					</div>
        		</div>
        	</div>
        </div>
		
	</div>
</div>

@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script> 

    $(document).ready(function() 
    {
        $('#ordersTable').DataTable({
            language: {
                search: 		"Cerca nella tabella:",
                lengthMenu: "Mostra _MENU_ righe",
                info:       "Mostro da _START_ a _END_ su _TOTAL_ ritiri",
        				paginate: {
                    first:      "Primo",
                    previous:   "Precedente",
                    next:       "Prossimo",
                    last:       "Ultimo"
                },
			}
        });
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

    var map;
    var myModal;
	var markers = [];
	
    window.onload = () => {

    	// create the map
    	map = L.map('map').setView([44.79259497143775, 10.33288864424524], 14);
    	// add a street map ayer from openstreetmap by calling a template url
    	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    	    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    	}).addTo(map);
    	
    	getAndShowOrders();
    	
    	// show an hourglass untill we don't get the coordinates of all addresses
    	myModal = new bootstrap.Modal(document.getElementById('waitModal'), { })
    	myModal.show();		
    }


    	async function getAndShowOrders()
    	{
    		fetch("{{ route('pickups-get-today', $user->employee->id) }}", {method: 'GET' })
    	    .then(response => response.json())
    	    .then(data => 
    	    {
    	    	// hide the hourglass
    	    	myModal.hide();
    	    	
    			for (let i=0; i < data.length; i++)
    			{
        			if (data[i].lat == 0) // error getting this address
        			{
            			alert(`Errore! Indirizzo ${data[i].order.order_details.shipping_address} non trovato`); 
            			document.getElementById(`order_${data[i].order.id}`).style.backgroundColor = "rgba(255,20,20,0.3)";
        			}
        			else
        			{
        				addMapMarker(data[i], (i+1));
        			}
    			}
        	})
            .catch((error) => console.log("Errore nel reperire la lista degli ordini: "+ error));
    	}
    	 
        function addMapMarker(orderObj, seq_number) 
        {
            let thisMarker;
            if (orderObj.order.seq_number > 0)
            {
            	var numberIcon = new NumberIcon({iconUrl: '/images/map-markers/marker-'+seq_number+'.png'});
            	thisMarker = L.marker([orderObj.lat, orderObj.lng], {icon: numberIcon}).addTo(map)
       	    	.bindPopup("<a href='/pickups-detail-emp/"+orderObj.order.id+"'>"+orderObj.order.order_details.shipping_address+"</a>");
            }
            else
            {
            	thisMarker = L.marker([orderObj.lat, orderObj.lng]).addTo(map)
       	    	.bindPopup("<a href='/pickups-detail-emp/"+orderObj.order.id+"'>"+orderObj.order.order_details.shipping_address+"</a>");
            }
            markers.push({orderId: orderObj.order.id, marker: thisMarker});
        }

        var NumberIcon = L.Icon.extend({
            options: {
                iconSize:     [60, 85],
                iconAnchor:   [25, 84],
                popupAnchor:  [3, -85]
            }
        });

        function showOnMap(orderId)
        {
            for (var i=0; i<markers.length; i++)
            {
                if (orderId == markers[i].orderId)
                	markers[i].marker.togglePopup();
            }
        }
</script>    
@stop
