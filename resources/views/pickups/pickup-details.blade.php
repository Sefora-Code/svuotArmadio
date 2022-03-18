@extends('pickups.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row dettagli-ritiro">
			<div class="row title mb-5"><h1>Dettaglio ritiro {{$order->id}}</h1></div>
			<div class="row">
				<div class="col-lg-12">
					<div class="row mb-2">
						<div class="col text-right">Indirizzo specificato:</div>
						<div class="col">{{ $order->orderDetails->shipping_address }}</div>
					</div>
					<div class="row mb-2">
						<div class="col text-right">Data di prenotazione:</div>
						<div class="col">{{ date("d / m / Y", strtotime($order->created_at)) }}</div>
					</div>
					<div class="row mb-2">
						<div class="col text-right">Data del ritiro:</div>
						<div class="col">{{ date("d / m / Y", strtotime($order->orderDetails->pickup_date)) }} - {{ $order->orderDetails->time_frame }}</div>
					</div>
					<!--div class="row">
						<div class="col">Peso:</div>
						<div class="col">1-5Kg</div>
					</div -->
					<div class="row mb-2">
						<div class="col text-right">Volume:</div>
						<div class="col">1-{{$order->orderDetails->volume}} Sacchetti</div>
					</div>
					<div class="row mb-2">
						<div class="col text-right">Costo:</div>
						<div class="col">-</div>
					</div>
					<div class="row">
						<div class="col text-right">Stato:</div>
						<div class="col">{{ $order->fulfilled ? "Completato" : "Accettato" }}</div>
					</div>
				</div>
			</div>
		</div>
		
@endsection		