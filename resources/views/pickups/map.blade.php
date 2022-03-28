@extends('pickups.master')

@section('custom_head_js')
	<!-- use Leaflet library to load map and marker https://leafletjs.com -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
   
    <style>
    /* use viewport-relative units to cover page fully */
    body {
      height: 80vh;
      width: 100vw;
    }
    #map {
        height: 100%;
        width: 100%;
    }
    </style>
    
	<!-- use Leaflet library to load map and marker https://leafletjs.com -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

@endsection		

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="title mb-5 text-center"><h1>Mappa ritiri</h1></div>

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

@endsection		

@section('extra')            

	<div id="map" ></div>
		
@endsection		

@section('custom_js')
<script>

var map;
var myModal;

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
		fetch("{{ route('pickups-get-today', $thisEmployeeId) }}", {method: 'GET' })
	    .then(response => response.json())
	    .then(data => 
	    {
	    	// hide the hourglass
	    	myModal.hide();
	    	
			for (let i=0; i < data.length; i++)
			{
    			addMapMarker(data[i], (i+1));
			}
    	})
        .catch((error) => console.log("Errore nel reperire la lista degli ordini: "+ error));
	}
	 
    function addMapMarker(orderObj, seq_number) 
    {
    	var numberIcon = new NumberIcon({iconUrl: 'images/map-markers/marker-'+seq_number+'.png'});
    	L.marker([orderObj.lat, orderObj.lng], {icon: numberIcon}).addTo(map)
   	    .bindPopup("<a href='/pickups-detail-emp/"+orderObj.order.id+"'>"+orderObj.order.order_details.shipping_address+"</a>");
    }

    var NumberIcon = L.Icon.extend({
        options: {
            iconSize:     [60, 85],
            iconAnchor:   [25, 84],
            popupAnchor:  [3, -85]
        }
    });
	
</script>
@endsection		

<!-- 
<a href='https://www.freepik.com/vectors/infographic'>Infographic vector created by coolvector - www.freepik.com</a>
 -->