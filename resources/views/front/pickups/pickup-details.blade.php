@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row dettagli-ritiro">
			<div class="row title"><h1>Dettaglio ritiro {{$order->id}}</h1></div>
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col">Indirizzo specificato:</div>
						<div class="col">{{ $order->orderDetail->shipping_address }}</div>
					</div>
					<div class="row">
						<div class="col">Data di prenotazione:</div>
						<div class="col">{{ date("d / m / Y", strtotime($order->created_at)) }}</div>
					</div>
					<div class="row">
						<div class="col">Data del ritiro:</div>
						<div class="col">{{ date("d / m / Y", strtotime($order->orderDetail->pickup_date)) }} - {{ $order->orderDetail->time_frame }}</div>
					</div>
					<!--div class="row">
						<div class="col">Peso:</div>
						<div class="col">1-5Kg</div>
					</div -->
					<div class="row">
						<div class="col">Volume:</div>
						<div class="col">1-{{$order->orderDetail->volume}} Sacchetti</div>
					</div>
					<div class="row">
						<div class="col">Costo:</div>
						<div class="col">-</div>
					</div>
					<div class="row">
						<div class="col">Stato:</div>
						<div class="col">{{ $order->fulfilled ? "Completato" : "Accettato" }}</div>
					</div>
				</div>
			</div>
		</div>
		
@endsection		