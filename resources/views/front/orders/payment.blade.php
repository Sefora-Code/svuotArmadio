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
				<div class="row pagamento">
					<div class="row"><h1>Costo totale del ritiro</h1></div>
					<div class="row">
						<div class="col-lg-12 dati">
							<div class="row">
								<div class="col">Ritiro in centro a Parma</div>
								<div class="col">€10</div>
							</div>
							<!-- add other costs -->
							<hr />
							<div class="row totale">
								<div class="col">Totale (+iva)</div>
								<div class="col">€12,22</div>
							</div>

							<hr />

							<div class="row confirm">
								<div class="col"><a href="riepilogo.html" class="btn btn-secondary w-100 mx-auto"> Indietro </a></div>
								<div class="col"><button type="submit" name="pay-now" id="pay-now" class="btn btn-primary w-100 mx-auto"> <i class="fab fa-paypal"></i>

								Procedi con il pagamento </button></div> <!-- go to conferma.html -->
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		
@endsection		