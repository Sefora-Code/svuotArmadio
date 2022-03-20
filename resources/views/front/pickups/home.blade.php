@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')
		<div class="row storico-ritiri">
			<div class="row title mb-5"><h1>Storico ritiri</h1></div>
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
						<th scope="row"><a href="{{route('pickups-detail', $order->id)}}">{{$order->id}}</a></th>
						<td>{{ date("d / m / Y", strtotime($order->created_at)) }}</td>
						<td>{{ date("d / m / Y", strtotime($order->orderDetails->pickup_date)) }}</td>
						<td>{{ $order->orderDetails->shipping_address }}</td>
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
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		
@endsection		