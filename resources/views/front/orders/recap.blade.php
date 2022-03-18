@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row prenotazione-ritiro">
			<div class="row steps">
				<div class="progress row">
					<div class="progress-bar h-10 col-4" id="progress1">
						<a href="#">Info ritiro</a>
					</div>
					<div class="progress-bar bg-success h-10 col-4">
						<a href="#">Riepilogo</a>
					</div>
					<div class="progress-bar bg-secondary h-10 col-4" id="progress3">
						<a href="#">Pagamento</a>
					</div>
				</div>
				<div class="row riepilogo">
					<div class="row"><h1> Riepilogo del ritiro </h1></div>
					<div class="row dati">
						<div class="col-lg-12">
							<div class="row mx-auto">
								<div class="col"><h3> Indirizzo specificato: </h3></div>
								<div class="col"><i> {{ $newOrderDetail->shipping_address }} </i></div>
							</div>
							<div class="row mx-auto">
								<div class="col"><h3> Data e orario: </h3></div>
								<div class="col"><i> {{ date("d / m / Y", strtotime($newOrderDetail->pickup_date)) }} - {{ $newOrderDetail->time_frame }}</i></div>
							</div>
							<div class="row mx-auto">
								<div class="col"><h3> Range Volume: </h3></div>
								<div class="col"><i> da 1 a {{$newOrderDetail->volume}} sacchetti </i></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-3 text-center">
				<div class="col">
					<a href="{{route('edit-order', $newOrderDetail->id)}}" class="btn btn-warning mx-auto w-50"> Modifica Informazioni </a>
				</div>
			</div>
			<div class="row mt-3 text-center">
				<div class="col">
					<a class="btn btn-primary mx-auto w-50" href="{{route('payment-order', $newOrderDetail->id)}}">Vai al pagamento</a>
				</div>
			</div>
		
@endsection		