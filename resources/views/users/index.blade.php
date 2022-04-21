@extends('adminlte::page')

@section('title', 'Utenti')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <style>
    .dt-button{margin-bottom: 20px;}
    </style>
@stop


@section('content_header')
    <h1>{{ Route::is('customers') ? 'Tutti i Clienti' : 'Tutti i Rider' }}</h1>
@stop

@section('content')

<div class="text-right mb-4 p-3" style="background-color: white;">
	<a class="btn btn-primary" href="{{ route('users.create') }}">Inserisci nuovo {{ Route::is('customers') ? 'cliente' : 'rider' }}</a>
</div>


<table id="usersTable" class="display">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Cognome</th>
<!--             <th>Tipo</th> -->
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
				@if(!strpos($user->email, 'admin') && !strpos($user->email, 'enotazioni'))
            	<tr>
    				<td>{{ $user->name }}</td>
    				<td>{{ $user->surname }}</td>
    <!-- 				<td>{{ $user->customer ? "Cliente" : "Dipendente" }}</td> -->
    				<td>{{ $user->email }}</td>
    				<td>{{ $user->address }}</td>
    				<td>{{ $user->phone_number }}</td>
    				<td>{{ $user->created_at }}</td>
    				<td>
    					@if($user->employee)
    						<a class="btn btn-info mb-2" href="{{route('rider.ordering.pickups', $user->employee->id) }}">Ordinamento ritiri</a>
    					@endif
    					<a class="btn btn-success mb-2" href="{{route('users.edit', $user->id) }}">Modifica</a>
    					<form action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-warning mb-2" onclick="remove('{{$user->id}}')">Elimina</button>
                        </form>
    				</td>
    	        </tr>
	        	@endif
	        @endif
        @endforeach
    </tbody>
</table>
    

@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/fh-3.2.0/datatables.min.js"></script>
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script> -->
<script> 

    $(document).ready(function() 
    {
        $('#usersTable').DataTable({
            dom: 'Blfrtip',
//             "order": [[ 5, 'desc' ]],
            buttons: [
//                 'csv',
                'excel',
                {
                    extend: 'pdf',
                	orientation: 'landscape',
            	    customize: function(doc) {
            	    	doc.styles.tableHeader.fontSize = 7
            	    	doc.defaultStyle.fontSize = 7;
            	    }
                },
//                 'print'
            ],
            language: {
                search: 		"Cerca nella tabella:",
                lengthMenu: "Mostra _MENU_ righe",
                info:       "Mostro da _START_ a _END_ su _TOTAL_ utenti",
        				paginate: {
                    first:      "Primo",
                    previous:   "Precedente",
                    next:       "Prossimo",
                    last:       "Ultimo"
                },
        			}
        });
    });
    
</script>    
@stop
