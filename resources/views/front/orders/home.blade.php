@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row prenotazione-ritiro">
			<div class="row steps">
				<div class="progress row">
					<div class="progress-bar h-10 col-4" id="progress1">
						<a href="#">Info ritiro</a>
					</div>
					<div class="progress-bar bg-secondary h-10 col-4">
						<a href="#">Riepilogo</a>
					</div>
					<div class="progress-bar bg-secondary h-10 col-4" id="progress3">
						<a href="#">Pagamento</a>
					</div>
				</div>
				<div class="row ritiro">
					<form method="post" action="{{isset($newOrderDetail) ? route('update-order', $newOrderDetail->id) : route('new-order')}}">
				    @csrf
						<div class="row mb-5">
							<h1> Prenota un ritiro </h1>
						</div>
						<div class="col-lg-12">
							<div class="row">
								<div class="col"><label for="address"> Indirizzo </label></div>
								<div class="col"><input type="text" name="shipping_address" id="address" class="form-control" placeholder="Indirizzo" value="{{ isset($newOrderDetail) ? $newOrderDetail->shipping_adress : $thisUser->address }}" required="required" /></div>
							</div>
							<hr />
							<div class="row">
								<div class="col"><label for="date"> Data </label></div>
								<div class="col"><input type="date" name="date" id="date" class="form-control" placeholder="Seleziona una data"  required="required" value="{{ isset($newOrderDetail) ? date('d/m/Y', strtotime($newOrderDetail->pickup_date)) : '' }}"/></div>
							</div>
							<hr />
							<div class="row">
								<div class="col"><label for="range-time"> Range Orario </label></div>
								<div class="col">
									<div class="form-check" id="range-time">
										<input class="form-check-input" type="radio" name="range_time" id="first-range" value="mattina" {{ isset($newOrderDetail) && $newOrderDetail->time_frame == "mattina" ? "checked" : "" }}/>
										<label class="form-check-label" for="first-range">
											Mattino
										</label>
									</div>
									<div class="form-check" id="range-time">
										<input class="form-check-input" type="radio" name="range_time" id="second-range" value="pomeriggio"  {{ isset($newOrderDetail) && $newOrderDetail->time_frame == "pomeriggio" ? "checked" : "" }} />
										<label class="form-check-label" for="second-range">
											Pomeriggio
										</label>
									</div>
									<div class="form-check" id="range-time">
										<input class="form-check-input" type="radio" name="range_time" id="third-range" value="sera"  {{ isset($newOrderDetail) && $newOrderDetail->time_frame == "sera" ? "checked" : "" }} />
										<label class="form-check-label" for="third-range">
											Sera
										</label>
									</div>
								</div>
							</div>
							<hr />
							<!--div class="row">
								<div class="col"><label for="range-weight"> Range Peso </label></div>
								<div class="col">
									<select class="form-control" name="range-weight" id="range-weight">
										<option value="default"> Seleziona il peso </option>
										<option value="5"> 1-5 Kg </option>
										<option value="10"> 5-10 Kg </option>
									</select>
								</div>
							</div>
							<hr /-->
							<div class="row">
								<div class="col"><label for="range-volume"> Range volume </label></div>
								<div class="col">
									<select class="form-control" id="range-volume" name="range_volume" required="required">
										<option value="default"> Seleziona il volume </option>
										<option value="2" {{ isset($newOrderDetail) && $newOrderDetail->volume == 2 ? "selected" : "" }} > 1 - 2 Sacchetti </option>
										<option value="4" {{ isset($newOrderDetail) && $newOrderDetail->volume == 4 ? "selected" : "" }} > 2 - 4 Sacchetti </option>
										<!-- Add more volume range ..... -->
									</select>
								</div>
							</div>	
							<br><br>
							<div class="row"><button type="submit" class="btn btn-primary mx-auto w-50" name="next-book-reservation"> Procedi con la prenotazione </button></div> <!-- go to page riepilogo.html -->
						</div>
					</form>
				</div>
			</div>
		</div>
@endsection		