	@foreach($msgs as $msg)
		@if(Auth::check())
			@if($msg->User1ID!=0)
				<? $class="msg_me";
					//$logo=$user1logo;
				?>

			@else
				<? $class="msg_you" ?>
		@endif	
		@else
			@if($msg->User2ID!=0)
				<? $class="msg_me";
					//$logo=$user2logo;
				?>

			@else
				<? $class="msg_you" ?>

			@endif	
		@endif
	
		<div class="{{$class}}">
			{!!$msg->Message!!}
		</div>
	
	@endforeach	