@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')
		<div class="row storico-ritiri">
			<div class="row title"><h1>Storico ritiri</h1></div>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Ritiro</th>
						<th scope="col">Data Prenotazione</th>
						<th scope="col">Data ritiro</th>
						<th scope="col">Indirizzo Ritiro</th>
						<th scope="col">Stato</th>
					</tr>
				</thead>
				<tbody>
				@foreach($orders as $order)
					<tr>
						<th scope="row"><a href="dettagli-ritiro.html">{{$order->id}}</a></th>
						<td>{{ date("d / m / Y", strtotime($order->created_at)) }}</td>
						<td>{{ date("d / m / Y", strtotime($order->orderDetail->pickup_date)) }} - {{ $order->orderDetail->time_frame }}</td>
						<td>{{ $order->orderDetail->shipping_address }}</td>
						<td>{{ $order->fulfilled ? "Completato" : "Accettato" }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		
@endsection		