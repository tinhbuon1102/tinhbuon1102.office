@extends('adminLayout')
@section('head')
    <title>シェアユーザーリスト</title>
@stop
@section('PageTitle')
	シェアユーザーリスト
@stop
@section('Content')
	
	
	
	<div class="row">
                <div class="col-lg-12">
				@if(session()->has('suc'))
					 <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ session()->get('suc') }}
                     </div>

				@endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            スペース一覧
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
								<form method="post" action="/MyAdmin/Spaces">
													{{ csrf_field() }}

							  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th style="width: 10%"></th>
                                            <th >時間毎</th>
                                            <th>スペースタイプ</th>
                                            <th>レントユーザー名</th>
                                            <th>金額</th>
											<th>ステータス</th>
											<th>設定</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($spaces as $space)
                                        <tr class="odd gradeX">
                                            <td><input tabindex="1" type="checkbox" name="delete[]" id="delete-{{$space->id}}" value="{{$space->id}}"> </td>
                                            <td><img class="wl-image" src="{{getSpacePhoto($space)}}"></td>
                                            <td><a target="_blank" href="/ShareUser/ShareInfo/View/{{$space->HashID}}">{{$space->Title}}</a></td>
                                            <td>{{$space->Type}}</td>
                                            <td>{{getUser2Name($space->shareUser)}}</td>
                                            <td>{{getPrice($space, true, '', true, false)}} /{{getSpaceTypeText($space)}}</td>
                                            <td>{{getStatusName($space->status)}}</td>
                                            <td><a target="_blank" href="/MyAdmin/ShareUser/{{$space->shareUser->HashCode}}/EditSpace/{{$space->HashID}}">Edit</a></td>
                                        </tr>
									@endforeach	
                                       
                                    </tbody>
                                </table>
                                <input type="hidden" value="Delete" name="deletebtn">
								<input type="button" value="Delete" name="deletebtn" id="bulk_delete">
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
			
			
			

@stop
@section('Footer')

  
 <script>
    $(document).ready(function() {
        $('body').on('click', '#bulk_delete', function(e){
            e.preventDefault();
            if(confirm('Are you sure you want to delete ?')) {
                $(this).closest('form').submit();
            }
        });
        $('#dataTables-example').DataTable({
                responsive: true,
                "columnDefs": [
					{ "width": "10%", "targets": 1 },
					{ "width": "30%", "targets": 2 },
					{ "type": "formatted-num", "targets": 4 }
				],
				"pageLength": 50,
				<?php echo getDataTableTranslate()?>
        });
    });
    </script>
@stop
