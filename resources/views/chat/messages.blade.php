	<?/* if(Auth::check() && !empty(Auth::user()->Logo))
						$user1logo=$Auth::user()->>Logo;
					else 
						$user1logo='/images/man-avatar.png';	
		if(Auth::guard('user2')->check() && !empty(Auth::guard('user2')->user()->Logo))
												$user2logo=Auth::guard('user2')->user()->Logo;
											elseif(Auth::guard('user2')->user()->Sex=='女性')
												$user2logo='/images/woman-avatar.png';
											else 
												$user2logo='/images/man-avatar.png';	
								
	*/ ?>		

	@foreach($msgs as $msg)
		@if(Auth::check())
			@if($msg->User1ID!=0)
				<? $class="me";
					//$logo=$user1logo;
				?>
						<? $logo=$logo1; ?>

			@else
				<? $class="you" ?>
		<? $logo=$logo2; ?>		
		@endif	
		@else
			@if($msg->User2ID!=0)
				<? $class="me";
					//$logo=$user2logo;
				?>
					<? $logo=$logo2; ?>		

			@else
				<? $class="you" ?>
						<? $logo=$logo1; ?>

			@endif	
		@endif
	
		<li class="{{$class}}">
			<img src="{{$logo}}" class="chat-pic" />
			<div class="txt">{!!$msg->Message!!}</div>
			<div class="msg-time">{{renderHumanTime($msg->created_at)}}</div>
		</li>
	
	@endforeach	