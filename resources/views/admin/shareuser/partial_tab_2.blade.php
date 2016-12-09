<?php 
//include (dirname(dirname(__FILE__)) . '/config.php');
?>
<div id="tab2_wraper">
	<h1 class="page-title">
		スペース
		<span class="space-count">({{$spaces->count()}})</span>
		<a href="javascript:void(0);" id="btn_load_shareinfo" class="yellow-button btn add-space-btn fright">スペースを追加</a>
		<!--スペース-->
	</h1>
			<div class="form-container">
					<form id="basicinfo">
						<fieldset>
						
							@foreach(Config::get('lp.budgetType') as $bud => $ar ) 
								<?php  
								$myspace = $spaces->where('FeeType',$ar['id']); ?>
								
								@if($myspace->count() > 0)
                        <div class="monthly-workspaces-wrapper">
                        <div class="workspace-list-header wl-row">
      <div class="wl-column h6" >{{$ar['display']}}</div>
      <div class="wl-column h7">スペースタイプ / 利用人数</div>
      <div class="wl-column h7">金額</div>
      <div class="wl-column h7">ステータス</div>
      <div class="wl-column"></div>
   </div>
   
   
   <!--list of space-->
   @foreach($myspace as $space)
   <div class="workspace-list-item h5 wl-row">
      <div class="wl-column" >
         <div class="wl-image-wrapper">
            <img  class="wl-image" src="{{getSpacePhoto($space)}}" >&nbsp;
         </div>
      </div>
      <div class="wl-column" >
         <div class="wl-info-line" >{{$space->Title}}</div>
         <div class="wl-info-line h7" >{{$space->Type}}</div>
         <div class="wl-info-line h7" >{{$space->Capacity}}人</div>
      </div>
      <div class="wl-column">
         <?php echo getPrice($space, true, '', true)?>
	   
       <!--  <div class="wl-info-line h7">Month-to-month</div>      -->   
         <!-- /ko -->
         <!-- ko if: $parent.type == 'SpecificTimePeriod' --><!-- /ko -->
      </div>
      <div class="wl-column">
         <!-- ko if: $data.HasIncompleteFields() --><!-- /ko -->
         <!-- ko if: !$data.HasIncompleteFields() -->
         <div class="workspace-actions-wrapper">                        
            <!-- ko if: $data.Booked() --><!-- /ko -->
            <!-- ko if: !$data.Booked() && WorkspaceStatus() == 1 -->
            <!--<a href="javescript:void(0)">Available</a>
            <div class="workspace-actions-modal">
            <div class="workspace-actions-popup">
               <a href="javascript:void(0)" onclick="manageWorkspacesModel.viewModel.hideWorkspace(this)" data-bind="attr: { 'data-workspaceId': $data.Id() }" data-workspaceid="6a520238-42ae-4370-b1a9-13fceee5992e">Not Available</a>
               
            </div>
            </div>-->
            {{getStatusName($space->status)}}
            <!-- /ko -->
            <!-- ko if: !$data.Booked() && WorkspaceStatus() == 2 --><!-- /ko -->
         </div>
         <!-- /ko -->
      </div>
      <div class="wl-column">
         <div class="workspace-actions-wrapper">
            <a class="action-tooltip font-icon fonticon-dots-three-horizontal"></a>
            <div class="workspace-actions-modal">
            <div class="workspace-actions-popup1">
               <a target="_blank" aclass="content-navigation editSpaceAdmin" data-id="{{$space->HashID}}" href="{{ url('MyAdmin/ShareUser/'. $user->HashCode .'/EditSpace/'.$space->HashID) }}" >編集</a>               
               <!--<a target="_blank" href="">Preview</a>-->
               <a href="{{ url('ShareUser/Dashboard/ShareInfo/Duplicate/'.$space->HashID) }}" >複製</a>               
               <a href="javascript:void(0)" onclick="deleteSpace('{{$space->HashID}}')">削除</a>
            </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
   <!--/list of space-->
   
   
   </div><!--/wrapper-->
   
		@endif
	@endforeach                    
						</fieldset>
					<div class="hr"></div>
					
				</form>
			</div>
		
	
	
	
	
	
	
	
	</div>

<div id="partial_tab_2_form_wraper" style="display: none;">
	
</div>
<script>

function deleteSpace(id)
{
	var result = confirm("本当に削除しますか");
	if (result) {
		window.location.href = "{{url('ShareUser/Dashboard/ShareInfo/Delete')}}/"+id + '?admin=1';
	}
}

$('body').on('click', '#btn_load_shareinfo', function (e) {
	e.preventDefault();
	$.get(
		'{{$user->HashCode}}/AddSpace',
		function(data) {
			$('#partial_tab_2_form_wraper').html(data);
			$('#tab2_wraper').hide();
			$('#partial_tab_2_form_wraper').show();
		}
		
	)
})
</script>

<script>
$('body').on('click', '.editSpaceAdmin', function (e) {
	e.preventDefault();
	var id=$(this).data("id");
	$.get(
		'{{$user->HashCode}}/EditSpace/'+id,
		function(data) {
			$('#partial_tab_2_form_wraper').html(data);
			$('#tab2_wraper').hide();
			$('#partial_tab_2_form_wraper').show();
		}
		
	)
})
</script>
<!-- /.row -->
