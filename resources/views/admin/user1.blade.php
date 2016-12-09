@extends('adminLayout') @section('head')
<title>シェアユーザーリスト</title>
@stop @section('PageTitle') シェアユーザーリスト @stop @section('Content')
<div class="row">
	<div class="col-lg-12">
		@if(session()->has('suc'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{ session()->get('suc') }}
		</div>
		@endif
		<div class="panel panel-default">
			<div class="panel-heading">シェア会員(貸す側)</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<form method="post" action="User1/DeleteM">
						{{ csrf_field() }}
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th></th>
									<th>会社名</th>
									<th>担当者名</th>
									<th>メールアドレス</th>
									<th>審査許可</th>
									<th>メール承認</th>
									<th>登録日</th>
									<th>設定</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr class="odd gradeX <?php if ($user->applicationForm && !$user->UserName) echo 'via-application'?>">
									<td>
										<input tabindex="1" type="checkbox" name="delete[]" id="delete-{{$user->id}}" value="{{$user->id}}">
									</td>
									<td>{{$user->NameOfCompany}}</td>
									<td>{{$user->LastName}} {{$user->FirstName}}</td>
									<td>{{$user->Email}}</td>
									<td>@if($user->IsAdminApproved=="Yes") 承認済み @else 未承認 @endif</td>
									<td>@if($user->IsEmailVerified=="Yes") 承認済み @else 未承認 @endif</td>
									<td>{{ $user->created_at->format('Y-m-d') }}</td>
									<td>
										<a href="User1/View/{{$user->id}}">見る</a>
										|
										<a href="/MyAdmin/ShareUser/{{$user->HashCode}}">編集</a>
										@if(!IsEmailVerified($user)) |
											<a href="/MyAdmin/User1/sendUser1EmailVerify/{{$user->id}}">メールアドレスを認証</a>
										@elseif(!IsAdminApprovedUser($user)) |
											<a href="/MyAdmin/User1/Approve/{{$user->id}}">承認する</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<input type="submit" value="Delete" name="deletebtn">
						<input type="submit" value="Approve" name="acceptbtn">
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
