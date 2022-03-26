@extends('pickups.master')

@section('title'){{ __('front.title_home') }}@stop

@section('custom_css')
<style>
    .btn-info{color: #fff;}
    .btn-success{background-color: #5cb85c; border-color: #4cae4c; }
</style>
@endsection

@section('body')

		<div class="row dettagli-ritiro">
			<div class="row title mb-5"><h1>Dettaglio ritiro</h1></div>
			<div class="row">
				<div class="col-lg-12">
					<div class="row mb-2">
						<div class="col text-right"><b>Indirizzo:</b></div>
						<div class="col">{{ $order->orderDetails->shipping_address }}</div>
					</div>
					<!--div class="row">
						<div class="col">Peso:</div>
						<div class="col">1-5Kg</div>
					</div -->
					<div class="row mb-2">
						<div class="col text-right"><b>Volume:</b></div>
						<div class="col">1-{{$order->orderDetails->volume}} Sacchetti</div>
					</div>
					<div class="row mb-2">
						<div class="col text-right"><b>Nome sul campanello e note:</b></div>
						<div class="col">{{$order->orderDetails->notes}}</div>
					</div>
					<div class="row mb-2 mt-4">
						<div class="col text-right">Costo:</div>
						<div class="col">-</div>
					</div>
					<div class="row mb-2">
						<div class="col text-right">Stato:</div>
						<div class="col">{{ $order->fulfilled ? "Completato" : "Accettato" }}</div>
					</div>
					<div class="row mb-2">
						<div class="col text-right">Data di prenotazione:</div>
						<div class="col">{{ date("d / m / Y", strtotime($order->created_at)) }}</div>
					</div>
					<div class="row mb-5">
						<div class="col text-right">Data del ritiro:</div>
						<div class="col">{{ date("d / m / Y", strtotime($order->orderDetails->pickup_date)) }} - {{ $order->orderDetails->time_frame }}</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col-6 text-right">
				<button class="btn btn-success mb-1" onclick="editOrder({{$order->id}}, 4)">RITIRATO</button>
			</div>
			<div class="col-6">
				<button class="btn btn-danger" onclick="editOrder({{$order->id}}, 5)">NON RITIRATO</button>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center">
				<button class="btn btn-info" onclick="window.history.back();">INDIETRO</button>
			</div>
		</div>
		
@endsection	
	
@section('custom_js')
<script>
function editOrder(orderId, newState)
{
	if (confirm("Sei sicuro?"))
	{
		// ajax call to update the order status
		fetch("{{ route('update.order.status') }}?o="+orderId+"&s="+newState, {method: 'GET'})
	    .then(response => response.json())
	    .then(data => 
	    {
			alert(data.text);
			window.location.href = "{{route('front-home')}}";
	    });
	}
	else
		alert("Azione annullata");
}
</script>
@endsection