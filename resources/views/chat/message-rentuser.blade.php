@include('pages.header')
<body class="mypage shareuser chatpage">
	<div class="viewport">
		@include('pages.header_nav_rentuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
												@include('user2.dashboard.left_nav')
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
				
				
					<section class="feed-event recent-follow feed-box">
						<div class="chat-left">
							<div class="head">
								<span>メッセージ履歴</span>
								<div style="clear: both;"></div> 
							</div><hr>
							
							<ul class="chat-list">
								@foreach($chatusers as $cuser)
									<li>
									<img src="@if(!empty($cuser->user1->Logo)){{$cuser->user1->Logo}}@elseif($cuser->user1->Sex=='女性'){{'//images/woman-avatar.png'}}@else{{'//images/man-avatar.png'}}@endif" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>{{$cuser->user1->LastName}} {{$cuser->user1->FirstName}}</h2><div class="chat-st"></div>
									<p>@if($cuser->latestChat()!=null)
										{{str_limit(strip_tags($cuser->latestChat()->Message),35)}}
									@endif &nbsp;
									</p><div class="chat-time">{{renderHumanTime($cuser->latestChat()->created_at)}}</div>
								</li>
								@endforeach
							</ul>
						</div>
						<!--/chat left end-->
						
						<div class="chat-right">
							<div class="head">
								<h2>Faraz Abbas</h2>
								<div class="chat-st active"></div>
								
								<div class="chat-icons">
								
								</div>
								<div style="clear: both;"></div> 
							</div><hr>
							
							<ul class="chat-list chats">
								<li class="me">
									<img src="/images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it</div>
								</li>
								<li class="you">
									<img src="/images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it This is my msg kindly appreciate it This is my msg kindly appreciate it</div>
								</li>
								<li class="me">
									<img src="/images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it</div>
								</li>
								<li class="you">
									<img src="/images/man-avatar.png" class="chat-pic" />
									<div class="txt">This is my msg kindly appreciate it This is my msg kindly appreciate it </div>
								</li>
							</ul>
							<div class="chat-send">
								<input type="text" class="chat-box" placeholder="メッセージを入力" />
								<div class="attach"><i class="fa fa-paperclip" aria-hidden="true"></i></div>
								<button class="chat-send-btn"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
							</div>
						</div>
						<!--/chat right end-->
						
						<div style="clear: both;"></div> 
					</section>
					
					
					

				</div>
				<!--/feed-->

			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script type="javascript/text">
      var $ = document.querySelector.bind(document);
      window.onload = function () {
        /*Ps.initialize($('.slimScrollDiv'));*/
      };
	  
    // var bodyheight = parseInt($(window).height()) - 100 +'px';
    // $("#left-box").height(bodyheight);
	//$('#left-box') .css({'height': (($(window).height()) - 100)+'px'});

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
     
     //>=, not <=
    if (scroll >= 1) {
        //clearHeader, not clearheader - caps H
        $("#samewidthby").addClass("scroll");
		 $("#left-box").addClass("scroll");
    } else {
		$("#samewidthby").removeClass("scroll");
        $("#left-box").removeClass("scroll");
    }
}); //missing );
</script>
<script>
$=jQuery.noConflict();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
	$.get(
					'/RentUser/Dashboard/GetMessage/{{$chat->id}}',
					function(data) {
						$('.chats').html(data);
					}
					
				);
	itemActionChannel.bind( "App\\Events\\NewChatMessage", function( data ) {
		if ($('li.user-id[data-id="'+ data.cid +'"]').length) {
			$('li.user-id[data-id="'+ data.cid +'"]').click();
		}
		else {
			$('.chat-container').append('<ul class="chat-list chats" id="chat-'+data.sid+'" style="display:none;"></ul>');
			$( ".user-list" ).prepend( "<li class='user-id' id='usr-"+data.sid+"' data-id='"+data.cid+"' data-uid='"+data.sid+"' data-name='"+data.name+"' style='cursor:pointer;'><img src='"+data.logo+"' class='chat-pic' /><div class='chat-count'>New</div><h2>"+data.name+"</h2><div class='chat-st'></div><p>&nbsp;</p><div class='chat-time'>&nbsp;</div></li>" );
		}

} );			
</script>
</body>
</html>
