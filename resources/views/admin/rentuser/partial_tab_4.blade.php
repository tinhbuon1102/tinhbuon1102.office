<div class="booking-dash-section">
	@if(session()->has('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ session()->get('success') }}
	</div>
	@endif
	<table class="table table-striped dataTable">
		<thead>
			<tr role="row">
				<th class="sorting">書類種類</th>
				<th class="sorting">ファイル名</th>
				<th class="sorting">備考</th>
			</tr>
		</thead>
		<tbody>
			@if($userIde->count()>0) @foreach($userIde as $i)
			<tr role="row">
				<td>{{$i->FileType}}</td>
				<td>
					<a href="{{$i->FilePath}}" target="_BLANK">{{$i->FilePath}}</a>
				</td>
				<td>{{$i->Description}}</td>
			</tr>
			@endforeach @else
			<tr role="row">
				<td colspan="3">まだ書類が提出されていません</td>
			</tr>
			@endif
		</tbody>
	</table>
	<div class="approve-buton">
		<form id="approve_form" action="{{url('MyAdmin/RentUser/'. $user->HashCode . '/Identify')}}" method="get">
			<input type="hidden" name="<?php echo ($user->IsAdminApproved == 'No') ? 'approve' : 'unapprove'?>" value="{{$user->id}}" />
			<input type="hidden" name="hash" value="#tab-4" />
			<button id="approveButton" class="btn btn-info submitSettingsBtn" type="submit">
				<?php echo ($user->IsAdminApproved == 'No') ? '承認する' : '非承認'?>
			</button>
		</form>
	</div>
</div>

<!-- /.row -->
