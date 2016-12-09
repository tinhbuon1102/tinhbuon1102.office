<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('head')
<link rel="stylesheet" href="{{ URL::asset('lpnew/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('lpnew/signup/style.css') }}">
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<script src="{{ URL::asset('lpnew/dist/js/vendor/jquery.min.js') }} "></script>
<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>

<style>
.signup-view .form-container .error {
	color: red !important;
}
</style>
</head>

<body class="signup-page contact-page">
	<div id="page-wrapper" class="signup-view">
		<div class="con-form-container">
			@yield('content')
		</div>
	</div>
	
	@yield('footer')
	
</body>
</html>	