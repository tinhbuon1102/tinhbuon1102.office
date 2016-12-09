@extends('commanLayout')
@section('head')
	<meta name="description" content="">
    <meta name="author" content="">

    <title>Register User</title>
@stop
@section('content')
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
					</label>
				@endif
	
				<form method="post" id="frm" action="/RegisterUser1/Save">
					{{ csrf_field() }}
					 <div class="form-group">
						<label>{{ trans('pages.NameOfCompany') }}</label>
						<input value="{{ old('NameOfCompany') }}" type="text" class="form-control" id="NameOfCompany" placeholder="{{ trans('pages.NameOfCompany') }}" name="NameOfCompany" required>
					</div>
					 <div class="form-group">
						<label>{{ trans('pages.NameOfPresident') }}</label>
						<input value="{{ old('NameOfPresident') }}" type="text" class="form-control" id="NameOfPresident" placeholder="{{ trans('pages.NameOfPresident') }}" name="NameOfPresident" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.NameOfPerson') }}</label>
						<input value="{{ old('NameOfPerson') }}" type="text" class="form-control" id="NameOfPerson" placeholder="{{ trans('pages.NameOfPerson') }}" name="NameOfPerson" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.Address') }}</label>
						<input value="{{ old('Address') }}" type="text" class="form-control" id="Address" placeholder="{{ trans('pages.Address') }}" name="Address" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.Tel') }}</label>
						<input value="{{ old('Tel') }}" type="text" class="form-control" id="Tel" placeholder="{{ trans('pages.Tel') }}" name="Tel" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.Email') }}</label>
						<input value="{{ old('Email') }}" type="text" class="form-control" id="Email" placeholder="{{ trans('pages.Email') }}" name="Email" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.Password') }}</label>
						<input value="{{ old('Password') }}" type="password" class="form-control" id="Password" placeholder="{{ trans('pages.Password') }}" name="Password" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.CPassword') }}</label>
						<input value="{{ old('CPassword') }}" type="password" class="form-control" id="CPassword" placeholder="{{ trans('pages.CPassword') }}" name="CPassword" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.EstablishDate') }}</label>
						<input value="{{ old('EstablishDate') }}" type="text" class="form-control" id="EstablishDate" placeholder="{{ trans('pages.EstablishDate') }}" name="EstablishDate" required>
					</div>
					<div class="form-group">
						<label>{{ trans('pages.BusinessSummary') }}</label>
						<textarea id="BusinessSummary" class="form-control" placeholder="{{ trans('pages.BusinessSummary') }}" name="BusinessSummary" required>{{ old('BusinessSummary') }}</textarea>
					</div>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary">{{ trans('pages.Submit') }}</button>
					</div>
				</form>
			</div>
		</div>
		
@stop
@section('footer')
<script>
			$("#frm").validate();
		</script>
@stop		