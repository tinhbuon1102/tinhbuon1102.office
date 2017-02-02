@if(getAuth())
<script>
	jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});
</script>
    <link href="/css/instantchat.css?v=6" rel="stylesheet">
    <script src="/js/instantchat.js?v=6" type="text/javascript"></script>
    <script src="/js/list.js?v=4" type="text/javascript"></script>
<div class="chat_box" id="iuserlist">
	<div class="chat_head">コンタクトリスト</div>
	
	<div class="chat_body list"  >
	<div class="ContactList-search">
	<div class="InputCombo InputCombo--bordered InputCombo--compact">
	<div class="InputCombo-inner">
	<span class="InputCombo-icon Icon Icon--small"><i class="fa fa-search" aria-hidden="true"></i></span>
	<input class="search InputCombo-input small-input ContactList-search-input ng-pristine ng-untouched ng-valid" placeholder="検索" />
	</div>
	</div>
	</div>
	<div class="ContactList-content ps-container ps-theme-default">
	<section class="ContactList-section">
	<div class="ContactList-thread">
	<? $ilast_activity = \Carbon\Carbon::now()->subSeconds('1500');
		if(Auth::guard('user2')->check())
		{
			$iuser=Auth::guard('user2')->user()->HashCode;
			$whichuser='user2';
			$iusers='user1';
			$iuserID='User1ID';
		}
		else{
			$iuser=Auth::guard('user1')->user()->HashCode;
			$whichuser='user1';
			$iusers='user2';
			$iuserID='User2ID';
		}
		if(Cache::get('instantChatUsers-'.$iuser))
	foreach(Cache::get('instantChatUsers-'.$iuser) as $icuser) 
									{
					if(Auth::guard('user2')->check())
					{				
						$iactivity='';
						$online='';
												if($icuser->user1->LastActivity >= $ilast_activity)
												{
													$iactivity='iactive';
													$online='online';
													
												}
					}
					else{
							$iactivity='';
							$online='';
												if($icuser->user2->LastActivity >= $ilast_activity)
												{
													$iactivity='iactive';
													$online='online';
												}
					}
									?>
	<div class="user {{$iactivity}}" id='iuser-{{$icuser->$iuserID}}' data-online="{{$online}}" data-whichuser="{{$whichuser}}"  data-id='{{$icuser->$iuserID}}' data-cid="{{$icuser->id}}" data-name='{{getUserName($icuser->$iusers)}}'><span class="iusername">{{getUserName($icuser->$iusers)}}</span></div>								
									<?
									}
									?>
									</div>
									</section>
	</div>
		</div>
			

 </div>

  <div class="msg_container">
		<div class="msg-scroll">
		</div>
  </div>
  
  <script>
	jQuery('.chat_body').addClass(localStorage.chat);

	itemActionChannel.bind( "App\\Events\\NewChatMessage", function( data ) {
		<?php if(strpos(URL::previous(), '/Message')  === true){ ?>
          jQuery('#chat-'+data.sid).append('<li class="you"><img src="'+data.img+'" class="chat-pic" /><div class="txt">'+data.msg+'</div></li>')
			jQuery("#usr-"+data.sid + " .chat-count").text(+ jQuery("#usr-"+data.sid + " .chat-count").text()+1);
			jQuery("#usr-"+data.sid + " .chat-count").show();
			jQuery('#chat-'+data.sid).scrollTop(jQuery('#chat-'+data.sid)[0].scrollHeight);
											jQuery('#chat-'+data.sid).scrollTop(jQuery('#chat-'+data.sid)[0].scrollHeight);
		<? } ?>

					if(jQuery("#msg_box_" + data.sid).length == 0) {
						if(data.whichuser=='user1')
							{
									var url='/ShareUser/Dashboard/GetInstantMessage/'+data.cid;

							}
							else
							{
									var url='/RentUser/Dashboard/GetInstantMessage/'+data.cid;

							}
							jQuery.get(
									url,
									function(data1) {
									jQuery(".msg-scroll").append(getChat(data.sid,data.name,data1,data.whichuser,'online'));
									jQuery("#msg_box_" + data.sid +" .msg_body").scrollTop(jQuery("#msg_box_" + data.sid +" .msg_body")[0].scrollHeight);

							}
									
								);
					}
					else{	
					jQuery('#msg_box_'+data.sid+' .msg_wrap .msg_body').append('<div class="msg_you">'+data.msg+'</div>');
					jQuery('#msg_box_'+data.sid+' .msg_wrap .msg_body').scrollTop(jQuery('#msg_box_'+data.sid+' .msg_wrap .msg_body')[0].scrollHeight);
					jQuery("#msg_box_" + data.sid).show();
					jQuery("#msg_box_" + data.sid + " .msg_wrap").show();
					jQuery("#msg_box_" + data.sid).insertAfter(jQuery(".msg_box").last());
					}
			//PlaySound();
} );
  </script>
  <script>
	
	var options = {
  valueNames: [ 'iusername' ]
};

var iuserlist = new List('iuserlist', options);
 </script>
@endif 