@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row info-personali">
			<h1> Informazioni Personali </h1>
			<div class="col-lg-4">
				<img src="images/solo_testo_trasparente-01.png" class="img-thumbnail" width="350px"><!-- https://picsum.photos/300/300 -->
			</div>
			<div class="col-lg-8 mt-5">
				<form method="post" action="{{route('save-user-data')}}">
				    @csrf
					<div class="credentials">
						<h3> Informazioni di recapito </h3>
						<input type="text" name="address" id="address" class="form-control" placeholder="Indirizzo" value="{{ $thisUser->address }}" />
						<br><br>
						<hr />
						<br><br>
						<h3> Informazioni di contatto </h3>
						<div class="row mt-3 mb-3">
							<div class="col">
								<label for="number"> Numero di telefono </label>
								<input type="number" name="phone" id="phone" class="form-control" placeholder="Numero di telefono" value="{{ $thisUser->phone_number }}" maxlength="10" />
							</div>
							<div class="col">
								<label for="email"> Indirizzo e-mail </label>
								<input type="email" name="email" id="email" class="form-control" placeholder="Indirizzo Email" value="{{ $thisUser->email }}" />
							</div>
						</div>
						<h3> Password </h3>
						<input type="password" name="pwd" id="pwd" class="form-control" placeholder="Password account" />
						<small> Ultima modifica: 3 mesi fa </small>

						
						<br><br><br><br>
						<div class="row"><button type="submit" class="btn btn-primary mx-auto w-50" name="save" id="save"> Salva </button></div>
					</div>

					<input type="hidden" value="{{$thisUser->id}}" name="id">
				</form>
			</div>
		</div>
				
@endsection		