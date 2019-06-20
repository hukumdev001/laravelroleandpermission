<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
	<title>@yield('pagename') | {{ env('APP_NAME') }}</title>
	<meta  name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css')}}">
	@yield('css')
</head>
<body>
	<div class="main-wrapper">
		<div class="app" id="app">
			<header class="header">
				<div class="header-block header-block-collapse d-lg-none">
					<button class="collapse-btn" id="sidebar-collapse-btn">
						<i class="fa fa-bars"></i>
						
					</button>
				</div>

				<div class="header-block header-block-nav">
					<ul class="nav-profile">
						<li class="profile dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<span class="name"> {{ Auth::user()->name  }}
									
								</span>
							</a>

							<div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
								<a href="#" class="dropdown-item">
									<i class="fa fa-user icon"></i>  Profile
								</a>
								<a href="#" class="dropdownp-item">
									<i class="fa fa-gear icon"></i>Profile
								</a>

								<a href="#" class="dropdown-item">
									<i class="fa fa-gear icon"></i>Settings
								</a>
								<div class="dropdown-divider"></div>

								<form id="frm-logout" action="{{ route('logout')}}" method="POST" style="display:none;">
									{{ csfr_field() }}
									
								</form>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                <i class="fa fa-power-off icon"></i> Logout </a>
								
							</div>	

						</li>
					</ul>
				</div>
			</header>


			@include('admin.layouts.sidebar')

			<article class="content">
				@yield('content')
			</article>

			<footer class="footer">
				<div class="footer-block buttons">
					&copy; {{env('APP_NAME')}}
				</div>

				<div class="footer-block author">
					<ul>
						<li> Developed by
							<a href="#" target="_blank">hukka don </a>
							
						</li>
					</ul>

				</div>
			</footer>
		</div>
	</div>


	<div class="ref" id="ref">
		<div class="color-primary"></div>
		<div class="chart">
			<div class="color-primary">
				
			</div>
			<div class="color-secondary"></div>
		</div>
	</div>

	<script type="text/javascript" src="{{ asset('js/vendor.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	@yield('js')
</body>
</html>