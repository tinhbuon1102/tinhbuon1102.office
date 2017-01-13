@include('pages.config')
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex">
<title>offispo | アワーオフィス</title>
<link rel="stylesheet" href="<?php echo SITE_URL?>css/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="<?php echo SITE_URL?>css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<script type="text/javascript">
	var SITE_URL = '<?php echo SITE_URL?>';
</script>

<script class="rs-file" src="{{ URL::asset('js/assets/royalslider/jquery-1.8.3.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}" ></script>
<link href="{{ URL::asset('js/assets/preview-assets/css/reset.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('js/assets/preview-assets/css/github.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ URL::asset('css/form-style.css') }}">
<style>
	.signup-view .form-container .error
	{
		color:red !important;
	}
</style>
</head>
<body class="selectPage">
<div id="page-wrapper">
<div ui-view="" class="ng-scope">
<div class="signup-view ng-scope" ng-show="$root.pageLoaded" aria-hidden="false">
<div class="form-container">
			@if(session()->has('suc'))
				<div class="alert alert-success" role="alert">{{ session()->get('suc') }}</div>
			@endif
			@if(count($errors))
					<label class="error">
						@foreach($errors->all() as $error)
							{{ $error }} <br/>
						@endforeach
						@if(session()->has('err'))
							{{ session()->get('err') }}
						@endif
					</label>
				@endif
	
				<form method="post" id="frm" action="" >
					{{ csrf_field() }}
					<div class="input-container">
						<label>{{ trans('pages.Email') }}</label>
						<input value="{{ $email }}" type="text" class="form-control" id="Email" placeholder="{{ trans('pages.Email') }}" name="Email" required>
					</div>
					<div class="input-container">
						<label>Password</label>
						<input value="" type="password" class="form-control" id="password" placeholder="Password" name="password" required>
					</div>
					<div class="input-container">
						<label>Confirm Password</label>
						<input value="" type="password" class="form-control" id="password" placeholder="Confirm Password" name="password_confirmation" required>
					</div>
					
					<div class="input-container text-center">
						<button type="submit" class="btn btn-primary">{{ trans('pages.Submit') }}</button>
					</div>
				</form>
			</div>
		</div>
        </div>
		
</div>

	<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
	
	<script>
			$("#frm").validate();
		</script>
</body>
</html>