@extends('pickups.master')

@section('custom_head_js')

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.13.0/css/ol.css" type="text/css">
	
    <style>
    /* use viewport-relative units to cover page fully */
    body {
      height: 100vh;
      width: 100vw;
    }
    #map {
        height: 100%;
        width: 100%;
    }
    </style>
    
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.13.0/build/ol.js"></script>

@endsection		

@section('title'){{ __('front.title_home') }}@stop

@section('body')
			<div class="title mb-5 text-center"><h1>Mappa ritiri</h1></div>
<!-- 			<table class="table"> -->
<!-- 				<thead> -->
<!-- 					<tr> -->
<!-- 						<th scope="col">Ritiro</th> -->
<!-- 						<th scope="col">Data Prenotazione</th> -->
<!-- 						<th scope="col">Data ritiro</th> -->
<!-- 						<th scope="col">Indirizzo Ritiro</th> -->
<!-- 						<th scope="col">Stato</th> -->
<!-- 					</tr> -->
<!-- 				</thead> -->
<!-- 				<tbody> -->
<!-- 				@foreach($orders as $order) -->
<!-- 					@if($order->orderDetails->pickup_date == date('Y-m-d 00:00:00')) -->
<!--     					<tr> -->
<!--     						<th scope="row"><a href="{{route('pickups-detail', $order->id)}}">{{$order->id}}</a></th> -->
<!--     						<td>{{ date("d / m / Y", strtotime($order->created_at)) }}</td> -->
<!--     						<td>{{ date("d / m / Y", strtotime($order->orderDetails->pickup_date)) }}</td> -->
<!--     						<td>{{ $order->orderDetails->shipping_address }}</td> -->
<!--     						<td>{{ $order->fulfilled ? "Completato" : "Accettato" }}</td> -->
<!--     					</tr> -->
<!-- 					@endif -->
<!-- 				@endforeach -->
<!-- 				</tbody> -->
<!-- 			</table> -->

		
@endsection		

@section('extra')            

	<div id="map" ></div>
		
@endsection		

@section('custom_js')
<script>
	var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([10.33288864424524, 44.79259497143775]),
          zoom: 15
        })
      });
</script>
@endsection		
