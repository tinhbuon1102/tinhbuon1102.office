
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
@include('pages.header')
<!--/head-->
<body class="mypage">
<div class="viewport">
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
@include('pages.header_nav_rentuser')
<div class="main-container">
<div id="main" class="container fixed-container">
<div id="left-box" class="col_3_5">
	@include('user2.dashboard.left_nav')
					<!--/right-content-->
</div>
				<!--/leftbox-->
                <div id="samewidth" class="right_side">
                <div id="page-wrapper" class="nofix">
                <div class="page-header header-fixed">
<div class="container-fluid">
<div class="row">
<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
<h1 class="pull-left"><i class="fa fa-star" aria-hidden="true"></i> お気に入りリスト</h1>
</div>
</div>
</div>
</div><!--/page-header header-fixed-->
<div id="feed">
<section class="feed-event recent-follow feed-box">
<ul id="fav-feed-list">
<!--loop fav-->
@foreach ($favorite as $favrt)
<?php $space = $spaces->where('HashID',$favrt->SpaceId)->first();
 ?>
<li>
<div class="news-feed-wrapper">
<div class="news-feed-inner">
<div class="gry-border-box">
<div class="office-catch-info clearfix">
<div class="rfloat fav-button">
<div class="list-fav-btn">
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
		<!--<a href="javascript:void();" class="gry-btn yms_remove_fav" id="fav-btn" data-favspaceid="{{$favrt->SpaceId}}" data-toggle="modal" data-target="#modalConfirmDelete"><i class="fa fa-close" aria-hidden="true"></i>お気に入り取り消し</a>-->
<a data-favorited="Favorited" data-favorite="Favorite" data-tooltip="お気に入り取り消し" href="#" class="gry-btn added_fav button-favorite" id="fav-btn" onclick="return false;"><i class="fa fa-star" aria-hidden="true"></i>お気に入り追加済</a>

<!--if already added as favorite--<a href="#" class="gry-btn" id="fav-btn"><i class="fa fa-check" aria-hidden="true"></i>お気に入り追加</a>--/if already -->
</div>
</div>
<div class="office-feature-img"><a href="<?php echo getSpaceUrl($space->HashID)?>"><img  class="wl-image" src="{{$img}}" ></a></div>
<div class="office-catch-summary">
<h3><a href="<?php echo getSpaceUrl($space->HashID)?>">{{$space->Title}}</a></h3>
<p class="sp-price">¥80,000/月</p>

	   <p class="sp-price"><?php getPrice($space)?></p>
<p class="space-cat">プライベートオフィス<span class="capacity">{{$space->Capacity}}人</span></p>
<p class="space-addr">{{$space->Prefecture}}{{$space->District}}</p>
</div><!--/summary-->
</div>
</div><!--/gry-border-box-->
</div><!--/innner-->
</div></li>
@endforeach


</ul>
</section>
</div><!--/feed-->
</div>
<!--footer-->
@include('pages.common_footer')
<!-- BO YMS -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		
	$(".added_fav").webuiPopover({
		placement: 'auto-bottom',
		trigger:'hover',
		content:function() {          
            return '<a href="javascript:void(0);" data-favspaceid="{{$favrt->SpaceId}}" data-toggle="modal" data-target="#modalConfirmDelete">お気に入り取り消し</a>';
        }
	});
	
		$(".confirm_yms_remove_fav").click(function(){
			$('.confirm_yms_remove_fav').prop('disabled',true);
			//var favspaceid = $(this).data('favspaceid');
			var favspaceid = $('#favspaceid').val();
			$.ajax({
                type: "GET",
                url: "<?php URL::to('/') ?>/RentUser/AddFavoriteSpace/"+favspaceid+"?action=remove",
               // data: {response:rrf},
                success: function(data) { 
                	  
                	data = $.parseJSON(data)
                	console.log('data: ',data);
                	if(data.success==true){
                		$('#modalConfirmDelete #yms_message').html('<div class="alert alert-success"><?=trans("common.delete_success")?></div>');
                		setTimeout(function(){ 
	                       location.reload();
	                    }, 4000);
                	}else {
                		$('#modalConfirmDelete #yms_message').html('<div class="alert alert-danger"><?=trans("common.delete_error")?></div>');
                		$('.confirm_yms_remove_fav').prop('disabled',false);
                	}
                    setTimeout(function(){ 
                        $('.yms_message').html('');
                    }, 4000);
                },
                error: function() {                                       
                    alert('An error occurred. Please try again!');
                    $('.confirm_yms_remove_fav').prop('disabled',false);
                }
            });
		});
		$('#modalConfirmDelete').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) 
		  var favspaceid = button.data('favspaceid') 
		  console.log('favspaceid: ',favspaceid);
		  $('#favspaceid').val(favspaceid);
		})
	});

	
</script>
<!-- Modal confirm delete -->
<div id="modalConfirmDelete" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog"><!--  modal-sm -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{Lang::get('common.title_confirm_delete_fav')}}</h4>
      </div>
      <div class="modal-body">  
      	<div id="yms_message"></div>
        <!-- <p>{{Lang::get('common.text_confirm_delete_fav',array('spacetitle'=>'ttttt'))}}</p>           -->  
        <p>{{Lang::get('common.text_confirm_delete_fav')}}</p>           
      </div>
      <div class="modal-footer">
      	<input type="hidden" id="favspaceid" value="">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('common.cancel')}}</button>
        <button type="button" class="confirm_yms_remove_fav btn btn-primary">{{Lang::get('common.remove_fav')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
<!-- EO YMS --> 
<!--/footer-->
</div><!--/#page-wrapper-->

				</div>
				<!--/right_side-->
</div><!--/main-container-->

</div><!--/viewport-->
</body>
</html>
