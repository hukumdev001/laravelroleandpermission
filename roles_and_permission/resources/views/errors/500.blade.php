<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=dege">

	<title> 500 Error | {{ env('APP_NAME') }}</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/vendor.css')}}">
</head>
<body>
	<div class="app blank sidebar-opened">
		<article class="content">
			<div class="error-card global">
				<div class="error-title-block">
					<h1 class="error-title">500</h1>
					<h2 class="error-sub-title">Internal Server Error.</h2>
				</div>
				
			</div>
		</article>
		
	</div>

	<div class="ref" id="ref">
		<div class="color-primary">
			
		</div>
		<div class="chart">
			<div class="color-primary"></div>
			<div class="color-secondary"></div>
		</div>
	</div>

	<script type="text/javascript" src="{{ asset('js/vendor.js')}}"></script>
	<script type="text/javascript" src="{{ asset('js/app.js')}}"></script>
</body>
</html>