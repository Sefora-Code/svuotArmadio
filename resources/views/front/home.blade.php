@extends('front.master')

@section('title'){{ __('front.title_home') }}@stop

@section('body')

		<div class="row info-personali">
			<h1> Informazioni Personali </h1>
			<div class="col-lg-4">
				<img src="https://picsum.photos/300/300" class="img-thumbnail">
			</div>
			<div class="col-lg-8">
				<form method="post" action="">
					<div class="credentials">
						<h3> Informazioni di recapito </h3>
						<input type="text" name="address" id="address" class="form-control" placeholder="Indirizzo" value="Via Penelope, 40 Parma (PR) 43030" />
						<hr />
						<h3> Informazioni di contatto </h3>
						<div class="row">
							<div class="col">
								<label for="number"> Numero di telefono </label>
								<input type="number" name="phone" id="phone" class="form-control" placeholder="Numero di telefono" value="0123456789" maxlength="10" />
							</div>
							<div class="col">
								<label for="email"> Indirizzo e-mail </label>
								<input type="email" name="email" id="email" class="form-control" placeholder="Indirizzo Email" value="info@svuotarmadio.com" />
							</div>
						</div>
						<h3> Password </h3>
						<input type="password" name="pwd" id="pwd" class="form-control" placeholder="Password account" />
						<small> Ultima modifica: 3 mesi fa </small>


						<div class="row"><button type="submit" class="btn btn-primary mx-auto w-50" name="save" id="save"> Salva </button></div>
					</div>


				</form>
			</div>
		</div>
		
@endsection		