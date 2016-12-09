<script type="text/javascript">
	var SITE_URL = "{{ url('/') }}/";
</script>
<script src="{{url('/')}}/js/assets/custom.js"></script>
<script src="{{url('/')}}/js/application.js"></script>
<script src="{{ URL::asset('js/addel.jquery.min.js') }}" ></script>
<style>
/*.jcrop-thumb
	{
		margin-left: 420px;
		margin-top: -200px;
	}*/
</style>
<?php $message = Session::get('success'); ?>
@if( isset($message) )
<div class="alert alert-success">{!! $message !!}</div>
@endif
<h2 class="page-title">提供するオフィススペースについて</h2>
<p class="sub-title">提供するオフィススペース情報を入力して下さい。</p>
<div class="form-container">
	@if($IsEdit=='True')
		<form id="shareinfo" name="ShareInfo" method="post" action="{{ url('ShareUser/ShareInfo/'.$space->HashID) }}" class="fl-form ">
	@else
		<form id="shareinfo" name="ShareInfo" method="post" action="{{ url('ShareUser/ShareInfo') }}" class="fl-form ">
	@endif
	
		@include('user1.dashboard.edit-space-form')
		
		<fieldset>
			@if($IsEdit=='True' || $IsDuplicate=='True')
			<!--/form-field-->
			<div class="form-field no-btm-border no-btm-pad space-bld-fac">
				<div class="input-container">
					<label for="num-chair">タグ</label>
					<span class="field-number-input-withunit">
						<input style="display: none;" name="tags" id="space_tags" value="<?php echo implode(',',$aTagName);?>">
					</span>
				</div>
			</div>
			@endif
		</fieldset>
		
		<div class="hr"></div>
		<div class="btn-next-step">
			<button id="saveBasicInfo" type="submit" class="btn yellow-button input-basicinfo-button">保存する</button>
			<button id="saveDraft" name="saveDraft" value="1" formnovalidate type="submit" class="btn btn-default mt15 dblk-button">
				<i class="fa fa-floppy-o"></i>
				<span class="hidden-sm hidden-xs">下書き保存</span>
			</button>
			<button id="cancelBasicInfo" type="button" class="btn yellow-button input-basicinfo-button">キャンセル</button>
			<button id="previewBasicInfo" type="button" class="btn yellow-button input-basicinfo-button" data-url="/ShareUser/ShareInfo/View/<?php echo $space->HashID; ?>">プレビュー</button>
			{{csrf_field()}}
		</div>
		<input type="hidden" name="User1ID" value="{{$user->id}}" />
	</form>
	@include('pages.config')
	<script>
	jQuery( document ).ready(function($) {
		
		$("#previewBasicInfo").click( function() {
			var url = $(this).attr("data-url");
			 var hn = window.location.hostname;
			 url = "http://" + hn + url;
			 window.open(url,'_blank');
				
		});
		
	@if($IsEdit=='True' || $IsDuplicate=='True')
	
	var sampleTags = [];
		$('#space_tags').tagit({
			availableTags: sampleTags
		});
		$('#prefecture').val("{{$space->Prefecture}}");
 $('#choose_per_type').val("{{$space->FeeType}}");
 $('#choose_type_of_office').val("{{$space->Type}}");
 $('#HourMinTerm').val("{{$space->HourMinTerm}}")
 $('#WeekMinTerm').val("{{$space->WeekMinTerm}}")
 $('#MonthMinTerm').val("{{$space->MonthMinTerm}}")  		
 $('#status').val("{{$space->status}}")  		
	var i;
	for(i=1;i<8;i++)
	{			
		switch(i)
		{
			 case 1:
					if("{{$space->isClosedMonday}}" == "Yes")
					{
						$('input[name="isClosedMonday"]').attr('checked','checked');
						$('input[name="isClosedMonday"]').click();
					}
					if("{{$space->isOpen24Monday}}" == "Yes")
					{
						$('input[name="isOpen24Monday"]').attr('checked','checked');
						$('input[name="isOpen24Monday"]').click();
					}
				break;
			case 2:
					if("{{$space->isClosedTuesday}}" == "Yes")
					{
						$('input[name="isClosedTuesday"]').attr('checked','checked');
						$('input[name="isClosedTuesday"]').click();
					}
					if("{{$space->isOpen24Tuesday}}" == "Yes")
					{
						$('input[name="isOpen24Tuesday"]').attr('checked','checked');
						$('input[name="isOpen24Tuesday"]').click();
					}
				break;
			case 3:
					if("{{$space->isClosedWednesday}}" == "Yes")
					{
						$('input[name="isClosedWednesday"]').attr('checked','checked');
						$('input[name="isClosedWednesday"]').click();
					}
					if("{{$space->isOpen24Wednesday}}" == "Yes")
					{
						$('input[name="isOpen24Wednesday"]').attr('checked','checked');
						$('input[name="isOpen24Wednesday"]').click();
					}
				break;
			case 4:				
					if("{{$space->isClosedThursday}}" == "Yes")
					{
						$('input[name="isClosedThursday"]').attr('checked','checked');
						$('input[name="isClosedThursday"]').click();
					}
					if("{{$space->isOpen24Thursday}}" == "Yes")
					{
						$('input[name="isOpen24Thursday"]').attr('checked','checked');
						$('input[name="isOpen24Thursday"]').click();
					}
				break;
			case 5:
					if("{{$space->isClosedFriday}}" == "Yes")
					{
						$('input[name="isClosedFriday"]').attr('checked','checked');
						$('input[name="isClosedFriday"]').click();
					}
					if("{{$space->isOpen24Friday}}" == "Yes")
					{
						$('input[name="isOpen24Friday"]').attr('checked','checked');
						$('input[name="isOpen24Friday"]').click();
					}
				break;
			case 6:
					if("{{$space->isClosedSaturday}}" == "Yes")
					{
						$('input[name="isClosedSaturday"]').attr('checked','checked');
						$('input[name="isClosedSaturday"]').click();
					}
					if("{{$space->isOpen24Saturday}}" == "Yes")
					{
						$('input[name="isOpen24Saturday"]').attr('checked','checked');
						$('input[name="isOpen24Saturday"]').click();
					}
				break;
			case 7:
					if("{{$space->isClosedSunday}}" == "Yes")
					{
						$('input[name="isClosedSunday"]').attr('checked','checked');
						$('input[name="isClosedSunday"]').click();
					}
					if("{{$space->isOpen24Sunday}}" == "Yes")
					{
						$('input[name="isOpen24Sunday"]').attr('checked','checked');
						$('input[name="isOpen24Sunday"]').click();
					}
				break; 
		}
	}
	@endif
	@if(Auth::check() && Auth::user()->Prefecture && $IsEdit=='False')
		jQuery('#prefecture').val("{{Auth::user()->Prefecture}}");
	@endif
	});
	</script>
</div>
@include('pages.footer_js')
