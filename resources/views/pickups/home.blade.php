@extends('pickups.master')

@section('title'){{ __('front.title_home') }}@stop

@section('custom_css')
<style>
    td{vertical-align: middle !important;}
    .btn-info{color: #fff;}
    .btn-success{background-color: #5cb85c; border-color: #4cae4c; }
</style>
@endsection

@section('body')
		<div class="row lista-ritiri">
			<div class="row title mb-5 text-center"><h1>Lista ritiri di oggi</h1></div>
			<table class="table">
				<thead>
					<tr>
<!-- 						<th scope="col">Ritiro</th> -->
<!-- 						<th scope="col">Data Prenotazione</th> -->
<!-- 						<th scope="col">Data ritiro</th> -->
						<th scope="col">Fascia oraria</th>
						<th scope="col" class="text-center">Indirizzo Ritiro</th>
<!-- 						<th scope="col">Stato</th> -->
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($orders as $order)
					@if($order->orderDetails->pickup_date == date('Y-m-d 00:00:00'))
    					<tr>
<!--     						<th scope="row"><a href="{{route('pickups-detail-emp', $order->id)}}">{{$order->id}}</a></th> -->
<!--     						<td>{{ date("d / m / Y", strtotime($order->created_at)) }}</td> -->
<!--     						<td>{{ date("d / m / Y", strtotime($order->orderDetails->pickup_date)) }}</td> -->
    						<td>{{ $order->orderDetails->time_frame }}</td>
    						<td>{{ $order->orderDetails->shipping_address }}</td>
<!--     						<td>
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
     						</td> -->
    						<td>
    							<a class="btn btn-info mb-1" href="{{route('pickups-detail-emp', $order->id)}}">Dettagli</a>
    							<br>
    							<button class="btn btn-success mb-1" onclick="editOrder({{$order->id}}, 1)">Ritirato</button>
    							<br>
    							<button class="btn btn-danger" onclick="editOrder({{$order->id}}, 2)">NON Ritirato</button>
    						</td>
    					</tr>
					@endif
				@endforeach
				</tbody>
			</table>
		</div>
		
@endsection

@section('custom_js')
<script>
function editOrder(orderId, newState)
{
	if (confirm("Sei sicuro?"))
	{
		// chiamata ajax per modificare l'ordine
	}
	else
		alert("Azione annullata");
}
</script>
@endsection