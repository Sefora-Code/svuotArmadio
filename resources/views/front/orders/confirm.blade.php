@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row prenotazione-ritiro">
			<div class="row steps">
				<div class="progress">
					<div class="progress-bar h-10" role="progressbar" style="width: 35%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
						<a href="#">Info ritiro</a>
					</div>
					<div class="progress-bar bg-success h-10" role="progressbar" style="width: 35%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
						<a href="#">Riepilogo</a>
					</div>
					<div class="progress-bar bg-info h-10" role="progressbar" style="width: 35%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
						<a href="#">Pagamento</a>
					</div>
				</div>
				<div class="row conferma">
					
				</div>
			</div>
		</div>
		
@endsection		