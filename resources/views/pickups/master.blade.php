<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>
    
    {{-- Base Stylesheets --}}	
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="../css/font-awesome/css/all.css" rel="stylesheet">
	
    {{-- Custom Stylesheets --}}	
    @yield('custom_css')
    
    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}"/>
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}"/>
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif
    
    {{-- Web Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Fredoka&display=swap" rel="stylesheet"> 
    
    
    {{-- Custom Header Scripts --}}
    @yield('custom_head_js')
</head>

<body @yield('body_data')>

  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @elseif(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
	@endif


    {{-- header Content --}}
	<nav class="navbar navbar-expand-lg navbar-light" id="menu-user-main">
		<div class="container-fluid">
    		<a class="navbar-brand" href="#">
<!--               <img src="images/logo-sefora-ocra-solo-img-300.png" alt="" width="80" height="60" class="d-inline-block align-text-bottom"> -->
              <span style="font-family: 'Fredoka', sans-serif; font-size: 3rem">lostello</span> <span style="font-family: 'Cookie', cursive; font-size: 3rem">porta a porta</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            	<span class="navbar-toggler-icon"></span>
            </button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link {{Route::is('front-home') ? 'active' : ''}}" aria-current="page" href="{{route('front-home')}}">Lista</a></li>
					<li class="nav-item"><a class="nav-link {{Route::is('pickups-map-emp') ? 'active' : ''}}" href="{{route('pickups-map-emp')}}">Mappa</a></li>
					<li class="nav-item ml-lg-5">
    					<form id="logout-form" action="/logout" method="POST" style=";">
                            <button class="btn btn-warning" type="submit">Esci</button>
                            {{ csrf_field() }}
                        </form>
					</li>
				</ul>
			</div>
		</div>
	</nav>


	<div class="container">
    
        {{-- Body Content --}}
        @yield('body')
        
	</div>
	
	{{-- Body Content out of a container --}}
    @yield('extra')
	
	{{-- Base Scripts --}}
    <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    {{-- Custom Scripts --}}
    @yield('custom_js')

</body>

</html>
    