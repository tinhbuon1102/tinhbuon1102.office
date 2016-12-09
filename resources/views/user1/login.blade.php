@extends('commanLayout')
@section('head')
	<meta name="description" content="">
    <meta name="author" content="">

    <title>User1 Login</title>
@stop
@section('content')
<div class="form-container">
<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3">
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
	
				<form method="post" id="frm" action="Validate">
					{{ csrf_field() }}
					<div class="form-group">
						<label>{{ trans('pages.Email') }}</label>
						<input value="" type="text" class="form-control" id="Email" placeholder="{{ trans('pages.Email') }}" name="Email" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.password') }}</label>
						<input value="" type="password" class="form-control" id="password" placeholder="{{ trans('pages.Password') }}" name="password" required>
					</div>
					
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary">{{ trans('pages.Submit') }}</button>
					</div>
				</form>
			</div>
		</div>
        </div>
		
@stop
@section('footer')
<script>
			$("#frm").validate();
		</script>
@stop		