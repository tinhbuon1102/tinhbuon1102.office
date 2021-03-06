@include('pages.header_beforelogin')
<? /*<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
*/ ?>
<script type="text/javascript" >
$(document).ready(function()
{

$(".account").click(function()
{
var X=$(this).attr('id');
if(X==1)
{
$(".submenu").hide();
$(this).attr('id', '0'); 
}
else
{
$(".submenu").show();
$(this).attr('id', '1');
}

});

//Mouse click on sub menu
$(".submenu").mouseup(function()
{
return false
});

//Mouse click on my account link
$(".account").mouseup(function()
{
return false
});


//Document Click
$(document).mouseup(function()
{
$(".submenu").hide();
$(".account").attr('id', '');
});
});
</script>

<!--/head-->
<body class="selectPage rentuser sharepage">
	<div class="viewport">
		<div class="header_wrapper primary-navigation-section">
			<header id="header">
				<div class="header_container dark">
					<div class="logo_container">
						<a class="logo" href="index.html">hOur Office</a>
					</div>
				</div>
			</header>
		</div>
		<div class="main-container">
			<div id="main" class="container">
				<h1 class="page-title">
					Spaces<span class="space-count">({{$spaces->count()}})</span>
                    <a href="{{url('ShareUser/Dashboard/ShareInfo')}}" class="yellow-button btn add-space-btn fright">スペースを追加</a>
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
		 <?php  $spaceImg= $space->spaceImage->where('Main','1')->all();
		 
			/*if($spaceImg->has('ThumbPath'))
				 echo $spaceImg->ThumbPath;
			*/
			$img="";
				foreach($spaceImg as $im)
					{
						$img = $im->ThumbPath;
						break;
					}
					
			?>
            <img  class="wl-image" src="{{$img}}" >&nbsp;
         </div>
      </div>
      <div class="wl-column" >
         <div class="wl-info-line" >{{$space->Title}}</div>
         <div class="wl-info-line h7" >{{$space->Type}}</div>
         <div class="wl-info-line h7" >{{$space->Capacity}}人</div>
      </div>
      <div class="wl-column">
         <!-- ko if: $parent.type == 'Period' -->
		@if($space->FeeType==1 || $space->FeeType==5)
	   <div class="wl-info-line">{{number_format( $space->HourFee ) }}円/時間</div>
	   @endif
		@if($space->FeeType==2 || $space->FeeType==5 || $space->FeeType==6)
	   <div class="wl-info-line">{{number_format( $space->DayFee ) }}円/日</div>
	   @endif
		@if($space->FeeType==3 || $space->FeeType==6 || $space->FeeType==7)
	   <div class="wl-info-line">{{number_format( $space->WeekFee ) }}円/週</div>
	   @endif
		@if($space->FeeType==4 || $space->FeeType==7)
	   <div class="wl-info-line">{{number_format( $space->MonthFee ) }}円/月</div>
	   @endif
	   
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
            未公開
            <!-- /ko -->
            <!-- ko if: !$data.Booked() && WorkspaceStatus() == 2 --><!-- /ko -->
         </div>
         <!-- /ko -->
      </div>
      <div class="wl-column">
         <div class="workspace-actions-wrapper">
            <a class="action-tooltip font-icon fonticon-dots-three-horizontal"></a>
            <div class="workspace-actions-modal">
            <div class="workspace-actions-popup">
               <a  class="content-navigation" href="{{ url('ShareUser/Dashboard/ShareInfo/'.$space->HashID) }}">編集</a>               
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
	</div>
	<!--footer-->
		@include('pages.common_instant_footer')
	<!--/footer-->
	<script>
		function deleteSpace(id)
		{
			var result = confirm("本当に削除しますか");
			if (result) {
			window.location.href = "{{url('ShareUser/Dashboard/ShareInfo/Delete')}}/"+id;
			}
		}
	</script>
</div>
<!--/viewport-->

	<!-- Typehead -->
	
	</body>
</html>
