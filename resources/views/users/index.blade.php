@extends('adminlte::page')

@section('title', 'Utenti')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
@stop


@section('content_header')
    <h1>Tutti gli Utenti</h1>
@stop

@section('content')

<div class="text-right mb-4 p-3" style="background-color: white;">
	<a class="btn btn-primary" href="{{ route('users.create') }}">Inserisci nuovo utente</a>
</div>


<table id="usersTable" class="display">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Tipo</th>
            <th>Email</th>
            <th>Indirizzo</th>
            <th>Telefono</th>
            <th>Creato il</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
		@foreach($users as $user)
			@if((Route::is('customers') && $user->customer) || (Route::is('riders') && !$user->customer)) 
        	<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->surname }}</td>
				<td>{{ $user->customer ? "Cliente" : "Dipendente" }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->address }}</td>
				<td>{{ $user->phone_number }}</td>
				<td>{{ $user->created_at }}</td>
				<td>
					<a class="btn btn-success mb-2" href="{{route('users.edit', $user->id) }}">Modifica</a>
					<form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-warning mb-2" onclick="remove('{{$user->id}}')">Elimina</button>
                    </form>
				</td>
	        </tr>
	        @endif
        @endforeach
    </tbody>
</table>
    

@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script> 

    $(document).ready(function() 
    {
        $('#usersTable').DataTable();
    });
    
</script>    
@stop
