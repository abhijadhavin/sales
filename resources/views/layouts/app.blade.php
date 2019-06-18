
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Sales Form Process</title>

	<!-- Fonts -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

	<!-- Styles -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

	<style>
		body {
			font-family: 'Lato';
			background-color: #fcf2ef; /* Orange */
		}
		.fa-btn {
			margin-right: 6px;
		}
	</style>
</head>
<body id="app-layout">
	<!-- Fixed navbar -->
	<nav class="navbar navbar-default">
	  <div class="container">
		<div class="navbar-header">
		  <!-- The mobile navbar-toggle button can be safely removed since you do not need it in a non-responsive implementation -->
			<a class="navbar-brand" href="{{ url('/') }}"> SALES FORM PROCESS </a> 
		</div>
		<!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
		<div id="navbar">
		  	
		  
		  <ul class="nav navbar-nav navbar-right">
		  	<li>
		  		<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
					  <input type="text" class="form-control" placeholder="Executive Id">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>	
		  	</li>
			<li><a href="/customer"><i class="fa fa-list"></i> CUSTOMER LIST DATA</a></li>
			<li><a href="/leads"><i class="fa fa-list"></i> LEADS DATA</a></li>
			<!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest			
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<?php /*
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">

				<!-- Branding Image -->
				<a class="navbar-brand" href="{{ url('/') }}">                    
					SALES FORM PROCESS
				</a>               
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/customer" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> CUSTOMER LIST DATA </a></li>
				<li><a href="/leads" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i>  LEADS DATA </a></li>
			</ul>
		</div>        
	</nav>
	*/ ?>

	@yield('content')

	<!-- JavaScripts -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
	
	@if (isset($links) && is_array($links))

		@foreach($links as $data)            
		   <script src="{{ asset('/js/'.$data) }}"></script>   
		@endforeach  
	@endif

</body>
</html>