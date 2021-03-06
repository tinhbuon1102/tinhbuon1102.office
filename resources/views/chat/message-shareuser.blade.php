@include('pages.header')
<body class="mypage shareuser chatpage">
	<style>
		.chat_box, .msg_container {display: none;}
	</style>
	<div class="viewport">
	@if(Auth::check())
		@include('pages.header_nav_shareuser')
	@else			
							@include('pages.header_nav_rentuser')
	@endif			
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
				@if(Auth::check())
							@include('user1.dashboard.left_nav')
							<? $whichuser1='user1'; ?>
				@else			
							@include('user2.dashboard.left_nav')
							<? $whichuser1='user2'; ?>
				@endif			
					<!--/right-content-->
				</div>
				<!--/leftbox-->
				<div class="right_side" id="samewidth">
				
				
					<section class="feed-event recent-follow feed-box">
						
						<div class="chat-left">
							<div class="head clearfix">
								<span>メッセージ履歴</span>
								
								<div style="clear: both;"></div> 
							</div><hr>
							<?php 							$last_activity = \Carbon\Carbon::now()->subSeconds('1500');
?>
							<div id="test" class="test">
							<ul class="chat-list user-list">
								@foreach($chatusers as $cuser)
								<?php 
										if(Auth::check())
										{
											$uid=$cuser->User2ID;
											$nm= getUserName($cuser->user2);
											if(!empty($cuser->user2->Logo))
												$logo=$cuser->user2->Logo;
											elseif($cuser->user2->Sex=='女性')
												$logo='/images/woman-avatar.png';
											else 
												$logo='/images/man-avatar.png';	
											$type="User2ID";
												$activity='';
												if($cuser->user2->LastActivity >= $last_activity)
												{
													$activity='active';
												}
										}
										else
										{
											$uid=$cuser->User1ID;
											$nm=getUserName($cuser->user1);
											if(!empty($cuser->user1->Logo))
												$logo=$cuser->user1->Logo;
											else 
												$logo='/images/man-avatar.png';		
											$type="User1ID";
											$activity='';
												if($cuser->user1->LastActivity >= $last_activity)
												{
													$activity='active';
												}
										}
										
											
								?>
									<li class='user-id' id="usr-{{$uid}}" data-id='{{$cuser->id}}' data-uid='{{$uid}}' data-name='{{$nm}}' data-online='{{$activity}}' style="cursor:pointer;">
									<img src="{{$logo}}" class="chat-pic" /><?php $cnt=readCount($cuser->id,$uid,$type); ?><div class="chat-count" @if($cnt==0) style='display:none;' @endif>{{$cnt}}</div>
									<h2>{{$nm}}</h2><div class="chat-st {{$activity}}"></div>
									@if($cuser->latestChat()!=null)
									<p>
										{{str_limit(strip_tags($cuser->latestChat()->Message),35)}}
									</p><div class="chat-time">{{renderHumanTime($cuser->latestChat()->created_at)}}</div>
									@endif &nbsp;
								</li>
								@endforeach
								<!--
								<li>
									<img src="/images/man-avatar.png" class="chat-pic" /><div class="chat-count" >7</div>
									<h2>Faraz Abbas</h2><div class="chat-st active"></div>
									<p>This is my msg kindly appreciate it...</p><div class="chat-time">2 min</div>
								</li>
								-->
							</ul></div>
						</div>
						<!--/chat left end-->
						
						<div class="chat-right flex-row fill-height">
                        <div class="flex-cell fill-height">
                        <div class="flex-column fill-height">
						
							<div class="head flex-cell-auto clearfix">
                            <button style="display:none; text-align:right;" id="goback"><i class="fa fa-chevron-left" aria-hidden="true"></i>戻る</button>
						<!--input type="button" style="background:url('back_btn.png'); display:none; text-align:right;" id="goback"/-->
								<h2 class='chat-name'></h2>
								<div class="chat-st isonline "></div>
								
								<div class="chat-icons">
								
								</div>
								<div style="clear: both;"></div> 
							</div><hr class="mb-none">
							<div class="chat-container flex-cell scroll-container">
								@foreach($chatusers as $cuser)
								<?php 
										if(Auth::check())
										{
											$uid=$cuser->User2ID;
										}
										else
										{
											$uid=$cuser->User1ID;										
										}
										?>
										
								<ul class="chat-list chats" id="chat-{{$uid}}"  data-loaded='No'>
									
								</ul>
								@endforeach
							</div>
                            <div class="flex-cell-auto">
							<div class="chat-send">
								<!--<input type="text" class="chat-box" id="text" placeholder="メッセージを入力" />-->
								<textarea class="chat-box" id="text" placeholder="メッセージを入力"></textarea>
								<input type="hidden" id="cid" name="cid" value="">
								<input type="hidden" id="whichuser1" name="whichuser1" value="{{$whichuser1}}">
								<div class="attach"><i class="fa fa-paperclip" aria-hidden="true"></i></div>
								<input type="file" class="imgupload1" style="display:none;"/>
								<button class="chat-send-btn"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
							</div>
                           </div>
                            </div>
                            </div>
						</div>
						<!--/chat right end-->
						
						<div style="clear: both;"></div> 
					</section>
					
					
					
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')
		
		<!--/footer-->
				</div>
				<!--/feed-->

			</div>
		</div>
		
		<!--/main-container-->
		
	</div>
	<!--/viewport-->
<script>
$=jQuery.noConflict();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function get(id,uid,nm,online)
{
	<?php 
	if(Auth::check())
	{
	?>	
	var url='/ShareUser/Dashboard/GetMessage/'+id;
	<?php
	}else
	{
	?>	
	var url='/RentUser/Dashboard/GetMessage/'+id;
	
	<?
	}
	?>
	$.get(
			url,
			function(data) {
				$('.chats').hide();
				$('.chat-name').html(nm);
				$('#chat-'+uid).show();
				$('#chat-'+uid).html(data);
				$('#chat-'+uid).attr('data-loaded','Yes')
				$("#cid").val(uid);
				$(".user-id").removeClass("active");
				$("#usr-"+uid).addClass("active");
				$("#usr-"+uid + " .chat-count").hide();
				$("#usr-"+uid + " .chat-count").text('0');
				$('#chat-'+uid).scrollTop($('#chat-'+uid)[0].scrollHeight);
				$('.isonline').removeClass('active');
				if(online=='active')
					{ $('.isonline').addClass('active'); }
	
				
				if (jQuery(window).width() <= 768)
				{
					setTimeout(function(){
						$('html, body').animate({
					        scrollTop: $('.chat-right .chat-container.scroll-container').offset().top
					    }, 1);
					}, 1);
				}
			}
			
		);
}
<?php 
if(Auth::check())
{
?>		
 @if ($chat->exists)								
<? 	$activity='';
		if($chat->user2->LastActivity >= $last_activity)
		{
			$activity='active';
		}
?>
 get('{{$chat->id}}','{{$chat->User2ID}}','{{getUserName($chat->user2)}}','{{$activity}}');
												
@endif
<?php
}else
{
?>
 @if ($chat->exists)								
<? 	$activity='';
		if($chat->user1->LastActivity >= $last_activity)
		{
			$activity='active';
		}
?>	
get('{{$chat->id}}','{{$chat->User1ID}}','{{getUserName($chat->user1)}}','{{$activity}}');
@endif
<?
}
?>
$(document).ready(function(){
    $(document).keyup(function(e) {
//         if (e.keyCode == 13)
//             sendMessage();
//         else
//             isTyping();
    });
	$('.chat-send-btn').click(function() { sendMessage(); } );
});

function sendMessage()
{
	
    var text = urlify($('#text').val());
    var id = $('#cid').val();

    if (text.length > 0)
    {
	<?	
		if(Auth::check())
										{
?>	
	var url='/ShareUser/Dashboard/SendMessage';
<?php
}else
{
?>	
	var url='/RentUser/Dashboard/SendMessage';

<?
}

if(Auth::check())
{
if( !empty(Auth::user()->Logo))
						$alogo=Auth::user()->Logo;
					else 
						$alogo='/images/man-avatar.png';	
}
else{
						if(Auth::guard('user2')->check() && !empty(Auth::guard('user2')->user()->Logo))
												$alogo=Auth::guard('user2')->user()->Logo;
											elseif(Auth::guard('user2')->check() && Auth::guard('user2')->user()->Sex=='女性')
												$alogo='/images/woman-avatar.png';
											else 
												$alogo='/images/man-avatar.png';
	}		?>	
		$("#usr-"+id + " .chat-count").hide();
		$("#usr-"+id + " .chat-count").text('0');	
		//$('#chat-window').append('<br><div style="text-align: right">'+text+'</div><br>');
		$('#chat-'+id).append('<li class="me"><img src="{{$alogo}}" class="chat-pic" /><div class="txt">'+text+'</div></li>')
		$('#text').val('');
		notTyping();
		$('#chat-'+id).scrollTop($('#chat-'+id)[0].scrollHeight);
						
        $.post(url, {text: text, id: id}, function()
        {
        });

    }
}

function isTyping()
{
    //$.post('http://localhost/chats/public/isTyping', {username: username});
}

function notTyping()
{
    //$.post('http://localhost/chats/public/notTyping', {username: username});
}
$('body').on('click',".user-id",function(){
	//alert($(this).data('id'));
	id=$(this).data('id');
	uid=$(this).data('uid');
	nm=$(this).data('name');
	online=$(this).data('online');
	if(true || $('#chat-'+uid).data('loaded')=='No')
	{
	get(""+id+"",""+uid+"",""+nm+"",""+online+"");
	
	}
	else{
			$('.chats').hide();
						$('.chat-name').html(nm);
						$('#chat-'+uid).show();
						$("#cid").val(uid);
						$(".user-id").removeClass("active");
						$("#usr-"+uid).addClass("active");
						$("#usr-"+uid + " .chat-count").hide();
						$("#usr-"+uid + " .chat-count").text('0');
						$('#chat-'+uid).scrollTop($('#chat-'+uid)[0].scrollHeight);
			}			
	
});


	jQuery('body').on('click', '.attach', function() {
		jQuery(this).siblings('.imgupload1').trigger('click');
	});
	
	
	jQuery('body').on('change', '.imgupload1', function() {
		var file_data = jQuery(".imgupload1").prop("files")[0];   // Getting the properties of file from file field
        var form_data = new FormData();                  // Creating object of FormData class
        form_data.append("file", file_data);              // Adding extra parameters to form_data
		
		var id=jQuery('#cid').val();
		var whichuser=jQuery('#whichuser1').val();
		
		form_data.append("id", id);
				if(whichuser=='user1')
				{
						var url='/ShareUser/Dashboard/SendFile';

				}
				else
				{
						var url='/RentUser/Dashboard/SendFile';

				}
		
        jQuery.ajax({
            url: url,
            cache: false,
            contentType: false,
			async:false,
            processData: false,
            data: form_data,                         // Setting the data attribute of ajax with file_data
            type: 'post',
            complete: function (data) {
					//alert(jQuery(this).parent().siblings('.msg_body').html());
				
				$('#chat-'+id).append('<li class="me"><img src="{{$alogo}}" class="chat-pic" /><div class="txt">'+data.responseText+'</div></li>')
		 
											$('#chat-'+id).scrollTop($('#chat-'+id)[0].scrollHeight); 
					
				              
            }
        })
	});
itemActionChannel.bind( "App\\Events\\NewChatMessage", function( data ) {
	if ($('li.user-id[data-id="'+ data.cid +'"]').length) {
		$('li.user-id[data-id="'+ data.cid +'"]').click();
	}
	else {
		$('.chat-container').append('<ul class="chat-list chats" id="chat-'+data.sid+'" style="display:none;"></ul>');
		$( ".user-list" ).prepend( "<li class='user-id' id='usr-"+data.sid+"' data-id='"+data.cid+"' data-uid='"+data.sid+"' data-name='"+data.name+"' style='cursor:pointer;'><img src='"+data.img+"' class='chat-pic' /><div class='chat-count'>New</div><h2>"+data.name+"</h2><div class='chat-st'></div><p>&nbsp;</p><div class='chat-time'>&nbsp;</div></li>" );
	}
});
	
/* today*/	

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	document.getElementsByClassName('chat-right')[0].style.display = 'none';
	//document.getElementsByClassName('fotter')[0].style.display = 'none';
$('li.user-id').on('click', function() {
	//alert("test");
  document.getElementsByClassName('chat-left')[0].style.display = 'none';
  document.getElementsByClassName('header_wrapper')[0].style.display = 'none';
  document.getElementById("goback").style.display = "block";
  document.getElementsByClassName('chat-right')[0].style.display = 'block';
 //document.getElementsByClassName('fotter')[0].style.display = 'block';
});
$("#goback").click(function(){
  document.getElementsByClassName('chat-left')[0].style.display = 'block';
  document.getElementsByClassName('header_wrapper')[0].style.display = 'block';
  document.getElementById("goback").style.display = "none";
  document.getElementsByClassName('chat-right')[0].style.display = 'none';
  //document.getElementsByClassName('fotter')[0].style.display = 'none';
});
/* テキストエリアの初期設定. */
 
// [1] height:30pxで指定
/*$("#text").height(30);
// [2] lineHeight:20pxで指定<ユーザ定義>(※line-heightと間違えないように)
$("#text").css("lineHeight","20px");*/
 
/**
 * 高さ自動調節イベントの定義.
 * autoheightという名称のイベントを追加します。
 * @param evt
 *
$("#text").on("autoheight", function(evt) {
  // 対象セレクタをセット
  var target = evt.target;
 
  // CASE1: スクロールする高さが対象セレクタの高さよりも大きい場合
  // ※スクロール表示される場合
  if (target.scrollHeight > target.offsetHeight) {
    // スクロールする高さをheightに指定
    $(target).height(target.scrollHeight);
  }
  // CASE2: スクロールする高さが対象セレクタの高さよりも小さい場合
  else {
    // lineHeight値を数値で取得      
    var lineHeight = Number($(target).css("lineHeight").split("px")[0]);
    
    while (true) {
      // lineHeightずつheightを小さくする
      $(target).height($(target).height() - lineHeight);
      // スクロールする高さが対象セレクタの高さより大きくなるまで繰り返す
      if (target.scrollHeight > target.offsetHeight) {
        $(target).height(target.scrollHeight);
        break;
      }
    }
  }
});
// DOM読み込み時に実行
$(document).ready(function() {
  // autoheightをトリガする
  $("#text").trigger('autoheight');
});*/

}
</script>
 

</body>
</html>
