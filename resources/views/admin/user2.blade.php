@extends('adminLayout') @section('head')
<title>レントユーザーリスト</title>
@stop @section('PageTitle') レントユーザーリスト @stop @section('Content')
<div class="row">
	<div class="col-lg-12">
		@if(session()->has('suc'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{ session()->get('suc') }}
		</div>
		@endif
		<div class="panel panel-default">
			<div class="panel-heading">ユーザー一覧</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<form method="post" action="User2/DeleteM">
						{{ csrf_field() }}
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th></th>
									<th>担当者名</th>
									<th>担当者名(かな)</th>
									<th>メールアドレス</th>
									<th>事業主タイプ</th>
									<th>事業種</th>
									<th>審査許可</th>
									<th>メール承認</th>
									<th>登録日</th>
									<th>設定</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr class="odd gradeX">
									<td>
										<input tabindex="1" type="checkbox" name="delete[]" id="delete-{{$user->id}}" value="{{$user->id}}">
									</td>
									<td>{{$user->LastName}} {{$user->FirstName}}</td>
									<td>{{$user->LastNameKana}} {{$user->FirstNameKana}}</td>
									<td>{{$user->Email}}</td>
									<td>{{$user->UserType}}</td>
									<td>{{$user->BusinessType}}</td>
									<td>@if($user->IsAdminApproved=="Yes") 承認済み @else 未承認 @endif</td>
									<td>@if($user->IsEmailVerified=="Yes") 承認済み @else 未承認 @endif</td>
									<td>{{ $user->created_at->format('Y-m-d') }}</td>
									<td>
										<a href="User2/View/{{$user->id}}">見る</a>
										|
										<a href="/MyAdmin/RentUser/{{$user->HashCode}}">編集</a>
										@if(!IsEmailVerified($user)) |
											<a href="/MyAdmin/User2/sendUser2EmailVerify/{{$user->id}}">メールアドレスを認証</a>
										@elseif(!IsAdminApprovedUser($user)) |
											<a href="/MyAdmin/User2/Approve/{{$user->id}}">承認する</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<input type="submit" value="削除">
					</form>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
@stop @section('Footer')
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
@stop
