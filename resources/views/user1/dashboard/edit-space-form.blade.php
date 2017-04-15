<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/assets/custom_edit_form.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/tag-it/js/tag-it.min.js') }}"></script>
<link href="{{ URL::asset('js/tag-it/css/jquery.tagit.css') }}" rel="stylesheet" type="text/css">

<?php 
	$validate_items = ['HourFee', 'WeekFee', 'MonthFee', 'HourFeeWeek', 'HourFeeSat', 'HourFeeSun', 'HourFeeHoliday', 'DayFeeWeekday', 'DayFeeSat', 'DayFeeSun', 'DayFeeHoliday'];
	$aRules = [];
	foreach ($validate_items as $validate_item){
		$aRules[$validate_item] = array('required' => true, 'min' => 1); 
	}
	
	$PostalCode= $space->PostalCode;
	$District=$space->District;
	$Address1=$space->Address1;
	$Address2=$space->Address2;
?>
<script type="text/javascript">
	var draftClick = false;
	var userData = <?php echo json_encode($user->toArray());?>;
	jQuery.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
	    }
	});
	jQuery.validator.addMethod('minStrict', function (value, el, param) {
	    return value > param;
	});

	jQuery("#shareinfo").validate({
  	errorPlacement: function(label, element) { 
		label.addClass('form-error');
		label.insertAfter(element);
		element.closest('.input-wraper').addClass('error');
	},
	rules: <?php echo json_encode($aRules);?>
});
	var missingImageAlert = '{{trans("common.Please add image for space !")}}';
</script>

<script>
jQuery(function($){
    
    // 全ての駅名を非表示にする
    jQuery(".budget-price").addClass('hide');
    // 路線のプルダウンが変更されたら
    jQuery("#choose_budget_per").change(function(){
        // 全ての駅名を非表示にする
        jQuery(".budget-price").addClass('hide');
        // 選択された路線に連動した駅名プルダウンを表示する
        jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
    });
})

</script>

<script type="text/javascript">
    jQuery(document).ready(function($) {

	$('.ttimg').webuiPopover();
	
	$('.addel').addel({
	  classes: {
		target: 'target',
		add: 'addel-add',
		delete: 'addel-delete'
	  }
	});

	$("#saveBasicInfo").click( function(){
		$("#shareinfo input, #shareinfo textarea, #shareinfo select").each( function(){
			var rf = $(this).attr("aria-required");
			if( rf ){
				if($(this).val() == ''){
					//$(this).css({"border-color": "#a94442","-webkit-box-shadow": "inset 0 1px 1px rgba(0,0,0,.075)","box-shadow": "inset 0 1px 1px rgba(0,0,0,.075)","background-color": "rgba(255, 192, 203, 0.34)"});
					$(this).addClass("req");
				}else{
					$(this).removeClass("req");
				}
			}
		});
	});

        $('#thumbviewimage, #profileImageUploader').click(function(e){
            e.preventDefault();
        });
        
        $('#popover_content_wrapper').on('show.bs.modal', function (e) {
	       	$('#popover_content_wrapper form[name="thumbnail"] #image-type').val($(e.relatedTarget).attr('image-type'));

	        // Change button name
            var image_type = $('form[name="thumbnail"] #image-type').val();
            if (image_type == 'main')
            {
                var btnUploadText = '<?php echo trans('common.Set as main image')?>';
            }
            else {
            	var btnUploadText = '<?php echo trans('common.Set as thumb image')?>';
            }
            $('input[name="upload_thumbnail"]').val(btnUploadText);	
            
        	$('#popover_content_wrapper form.uploadform .image-id').val($(e.relatedTarget).attr('image-type'));
        	if($(e.relatedTarget).attr('isbutton')=="yes")
			{
				for(i=1;i<5;i++)
				{
					if($(e.relatedTarget).attr('image-type')=="thumb_"+i)
					{
						j=i+1;
						$(e.relatedTarget).attr('image-type','thumb_'+j);
						break;
					}
				}
			}
			var imageData = $(e.relatedTarget).find('input').val();
        	if(imageData){
        		imageData = $.parseJSON(imageData);
        		showResponse(imageData);
            }
            
	   		// Init avatar image 
	     	<?php if (isset($_SESSION['space_image_image'])) :?>
	     		showResponse('<?php echo $_SESSION['space_image_image']?>');
	     		$('.popover #filename').val('<?php echo $_SESSION['space_image_image']?>');
	 		<?php endif?>

   		});

		$('.upload-button').click(function(){
		});
        $('#popover_content_wrapper').on('hidden.bs.modal', function (e) {
            // Remove the old uploaded image in popup
            $('.crop_preview_box_big').html('');
   		});

        function showResponseSubmit(response, statusText, xhr, $form){
            response = jQuery.parseJSON(response);
            if (typeof response == 'object' && response.file_thumb)
            {
	    		// Store data to hidden field
	    		var imageData = $('form[name="thumbnail"]').serialize();
	    		imageData = $.parseParams(imageData);
	    		//delete unset data
	    		delete imageData['_token'];
	    		delete imageData['backurl'];
	    		delete imageData['upload_thumbnail'];
	    		
	    		var image_type = $('form[name="thumbnail"] #image-type').val();
	    		$('#image_' + image_type).val(JSON.stringify(imageData));
	    		// Display image preview
	    		$('.edit-gallery-thumbnail-wrapper[image-type="'+image_type+'"] i.fa-times').removeClass('hide');
	    		$('.edit-gallery-thumbnail-wrapper[image-type="'+image_type+'"]').css('background-image', 'url("'+ (response.file_thumb) +'?t='+ (new Date().getTime()) +'")')
	    	
	            // Close modal
	            jQuery('#popover_content_wrapper').modal('toggle');
            }
            else {
                alert('Error Occured!');
            }
        }
        
        $('body').on('click', '#UseSameAddr', function(e){
            if ($(this).is(':checked'))
            {
                $('#zip').val(userData.PostalCode);
                $('#prefecture').val(userData.Prefecture);
                $('#district').val(userData.District);
                $('#SpaceAddr').val(userData.Address1);
                $('#SpaceAddr2').val(userData.Address2);
            }
            else {
            	$('#zip').val('');
                $('#prefecture').val('');
                $('#district').val('');
                $('#SpaceAddr').val('');
                $('#SpaceAddr2').val('');
            }
        });
    	$('body').on('click', '.edit-gallery-thumbnail-wrapper .fa-times', function(e){
    		e.stopPropagation();
    		if (!confirm('本当に削除しますか？'))
    		{
    			return false;
    		}
    		
    		var closeButton = $(this);
    		// Remove image
    		$.ajax({
        		url: '<?php echo action('User1Controller@deleteSpaceImage')?>',
        		data: {spaceID: closeButton.data('spaceid'), imageID: closeButton.data('imageid')},
        		method: 'post',
        		dataType: 'json',
        		success: function(response){
            		var parentDiv = closeButton.closest('.edit-gallery-thumbnail-wrapper');
            		parentDiv.removeAttr('style');
            		parentDiv.find('i.fa-times').addClass('hide');
            		parentDiv.find('.image_thumb').val('');
            		parentDiv.find('.image_thumb_id').val('');
            	}
        	});
    	});
    	
   /* 	$('body').on('click', '.modal.in #save_thumb', function(e) { */
    	$('body').on('click', '#save_thumb', function(e) {
        	e.preventDefault();
    		var x1 = $('.modal.in #x1').val();
    		var y1 = $('.modal.in #y1').val();
    		var x2 = $('.modal.in #x2').val();
    		var y2 = $('.modal.in #y2').val();
    		var w = $('.modal.in #w').val();
    		var h = $('.modal.in #h').val();
			
			
    		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
    			alert("<?php echo trans('common.Please make a selection first')?>");
    		}
			else{

    		// Ajax Upload and Crop
    		$('.modal.in form[name="thumbnail"]').ajaxForm({
            	url: $(this).attr('action'),
                success:    showResponseSubmit 
            }).submit();
			}
    	});

    	function updateCoords(c)
    	{
    		jQuery('.modal.in #x1').val(Math.ceil(c.x));
    		jQuery('.modal.in #x2').val(Math.ceil(c.x));
    		jQuery('.modal.in #y1').val(Math.ceil(c.y));
    		jQuery('.modal.in #y2').val(Math.ceil(c.y));
    		jQuery('.modal.in #w').val(Math.ceil(c.w));
    		jQuery('.modal.in #h').val(Math.ceil(c.h));
    	};
    	
    	function showResponse(response, statusText, xhr, $form){

    		if (typeof response == 'string')
    		{
    			response = $.parseJSON(response);
        		var responseText = response.name;
        		var imageSize = response.size;
        		
        		var aspectSmaller = imageSize[0] >= imageSize[1] ? imageSize[1] : imageSize[0];
        		var aspectBigger = imageSize[0] >= imageSize[1] ? imageSize[0] : imageSize[1];
        		
    			var imageArea = [ 0, 0, aspectBigger, aspectBigger ];
    		}
    		else
    		{
    			var responseText = response.filename;
    			var imageArea = [Math.ceil(response.x1), Math.ceil(response.y1), Math.ceil(response.w), Math.ceil(response.h)];
    			
    		}
    		
    		var wraperClass = '.modal.in ';
    		var image_src = "<?php echo UPLOAD_PATH_SPACE_TMP_URL; ?>" + responseText;
    		
    	    if(responseText.indexOf('.')>0){
    			$(wraperClass + ' #thumbviewimage').html('<img src="'+image_src+'"   style="position: relative;" alt="Thumbnail Preview" />');
    	    	$(wraperClass + ' #viewimage').html('<img class="preview" alt="" src="'+image_src+'?t='+ (new Date().getTime()) +'"   id="thumbnail" />');
    	    	$(wraperClass + ' #filename').val(responseText); 

		 		$(wraperClass + ' #thumbnail').Jcrop({
		 			  aspectRatio: 750/500,
		 		      boxWidth: 500,   //Maximum width you want for your bigger images
		 		      boxHeight: 300,  //Maximum Height for your bigger images
		 			  setSelect: imageArea,
		 			  onSelect: updateCoords,
		 			  onChange: updateCoords,
		 			},function(){
		 			  var jcrop_api = this;
		 			  thumbnail = this.initComponent('Thumbnailer', { width: 200, height: 133 });
		 			});
    		}else{
    			$(wraperClass + ' #thumbviewimage').html(responseText);
    	    	$(wraperClass + ' #viewimage').html(responseText);
    		}
        }

    	$('body').on('click', '.crop_box button', function(e){
        	e.preventDefault();
    	});
    	
    	$('body').on('click', '.modal.in #btn-image-save', function(){
        	$('.modal.in #imagefile').val('');
    		$('.modal.in #imagefile').click();
    	});

        $('body').on('change', '.modal.in #imagefile', function() {
        	$(".modal.in .uploadform").append('<input type="hidden" name="upload_type" value="space" />')
        	
        	$(".modal.in #viewimage").html('');
            $(".modal.in #viewimage").html('<img class="loading-image" style="width: auto !important" src="'+ SITE_URL +'images/loading.gif" />');
            $(".modal.in .uploadform").ajaxForm({
            	url: SITE_URL + 'upload-image.php',
                success:    showResponse 
            }).submit();
        });

        $('body').on('click', '#shareinfo button', function(e){
        	draftClick = false;
        	if ($(this).attr('id') == 'saveDraft') {
        		draftClick = true;
           	}
        })
        $('body').on('submit', '#shareinfo', function(e){
            // Validate
            if ($("#shareinfo").valid()){
            	if (!$('#image_main').val() && !$('input[name="dataimage[main_id]"]').val() && !draftClick) {
                    alert(missingImageAlert);
                    $('html,body').animate({ scrollTop: $('.edit-gallery-wrapper').offset().top  - 200}, 'slow');
                    return false;
                }
            }
            return true;
        })

        $('#zip').change();

        function showHideFlexiblePrice(feeType)
        {
    		    if(feeType == '1')
    		    {
    		        $('#hourDivBase').css('display','block');
    		        $('#dayDivBase').css('display','none');
    		        
    		    }
    		    else if(feeType == '2')
    		    {
    		        $('#hourDivBase').css('display','none');
    		        $('#dayDivBase').css('display','block');
    		        
    		    }
    		    else
    		    {
    		        $('#hourDivBase').css('display','none');
    		        $('#dayDivBase').css('display','none');
    		        
    		    }
        }

        $("select#choose_per_type").change(function(){
		    showHideFlexiblePrice($(this).val());
		})
        showHideFlexiblePrice($("select#choose_per_type").val());
    });
    
    
    

function MychkBoxchk(str,id){
//alert('yesbox');
   if(jQuery('#'+id).is(':checked')){
        jQuery("#"+str).css('display','block');
        jQuery(".fhoc").css('display','none');
        
   }else{
       jQuery("#"+str).css('display','none');
        jQuery(".fhoc").css('display','block');
   }
}
</script>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-container">
			@if (count($errors) > 0)
			<div class="form-error">
				<ul>
					@foreach($errors as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif {{ csrf_field() }}
			<?php if (!$isThisSpaceHasSlot && $space->status != SPACE_STATUS_DRAFT) {?>
			<div class="alert-container">
				<div class="dashboard-warn-text">
					<div class="dashboard-must-validation">
						<i class="icon-warning-sign fa awesome"></i>
						<div class="warning-msg">
							このスペースはカレンダーにてまだスケジュールが設定されていないため、非公開となっております。
							<br />
							<a href="{{url('/')}}/ShareUser/Dashboard/MySpace/Calendar" class="dashboard-must-text-link underline">カレンダーの設定はこちら</a>
						</div>
					</div>
				</div>
			</div>
			<?php }?>
			<?php if (session()->has('successDraft')) { ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo session()->get('successDraft')?>
	</div>
	<?php } ?>
			<div class="public-status">
				<div class="row">
					<div class="col-md-6 col-sm-8 clearfix">
						<label class="left-label" for="SpaceTitle">公開状態</label>
						<div class="input-container input-col3">
							<select name="status" id='status'>
								<option value="1">{{getStatusName(1)}}</option>
								<option value="2">{{getStatusName(2)}}</option>
								<option value="3">{{getStatusName(3)}}</option>
							</select>
						</div>
						<div class="show-member-input">
							<input type="checkbox" name="LoggedOnly" id="LoggedOnly" value="1" <?php echo ($space->LoggedOnly == 1 ? 'checked' : '')?>/> 会員のみに公開する
						</div>
					</div>
					<div class="col-md-6 col-sm-4 clearfix pb15 text-right last-update">
						<label class="inline" for="SpaceTitle">最終更新</label>
						{{$space->updated_at ? $space->updated_at->format('Y-m-d H:i') : ''}}
					</div>
				</div>
				<!--/row-->
			</div>
			<fieldset>
				<div class="Signup-sectionHeader">
					<legend class="signup-sectionTitle"> 基本情報 </legend>
				</div>
				<div class="form-field">
					<label for="SpaceTitle">
						<span class="require-mark">*</span>
						タイトル
						<span class="help">*サイトの掲載されるスペースの名前をご入力ください。</span>
					</label>
					<div class="input-container">
						<input name="Title" id="SpaceTitle" value="{{$space->Title}}" required="" ng-model="setting.space_title" type="text" class="ng-invalid" aria-invalid="true" placeholder="4人~6人用オープンデスク">
					</div>
				</div>
				<div class="form-field share-locate">
					<label for="require-place">
						<span class="require-mark">*</span>
						住所
					</label>
                    <span class="use-same-addr"><input type="checkbox" id="UseSameAddr">会社情報と同じ住所を使用する</span>
					<div class="form-field two-inputs nopd no-btm-border">
						<div class="input-container input-half withrightlabel">
							<label class="post-mark inline">〒</label>
							<input name="PostalCode" value="{{$PostalCode}}" required="" id="zip" type="text" 　class="ng-pristine ng-untouched ng-invalid-required" aria-required="true">
						</div>
					</div>
					<!--/form-field-->
					<div class="form-field two-inputs nopd no-btm-border">
						<div class="input-container input-half">
							<select id="prefecture" required name="Prefecture" data-label="都道府県を選択">
								<option value="北海道">北海道</option>
								<option value="青森県">青森県</option>
								<option value="岩手県">岩手県</option>
								<option value="宮城県">宮城県</option>
								<option value="秋田県">秋田県</option>
								<option value="山形県">山形県</option>
								<option value="福島県">福島県</option>
								<option value="茨城県">茨城県</option>
								<option value="栃木県">栃木県</option>
								<option value="群馬県">群馬県</option>
								<option value="埼玉県">埼玉県</option>
								<option value="千葉県">千葉県</option>
								<option value="東京都">東京都</option>
								<option value="神奈川県">神奈川県</option>
								<option value="新潟県">新潟県</option>
								<option value="富山県">富山県</option>
								<option value="石川県">石川県</option>
								<option value="福井県">福井県</option>
								<option value="山梨県">山梨県</option>
								<option value="長野県">長野県</option>
								<option value="岐阜県">岐阜県</option>
								<option value="静岡県">静岡県</option>
								<option value="愛知県">愛知県</option>
								<option value="三重県">三重県</option>
								<option value="滋賀県">滋賀県</option>
								<option value="京都府">京都府</option>
								<option value="大阪府">大阪府</option>
								<option value="兵庫県">兵庫県</option>
								<option value="奈良県">奈良県</option>
								<option value="和歌山県">和歌山県</option>
								<option value="鳥取県">鳥取県</option>
								<option value="島根県">島根県</option>
								<option value="岡山県">岡山県</option>
								<option value="広島県">広島県</option>
								<option value="山口県">山口県</option>
								<option value="徳島県">徳島県</option>
								<option value="香川県">香川県</option>
								<option value="愛媛県">愛媛県</option>
								<option value="高知県">高知県</option>
								<option value="福岡県">福岡県</option>
								<option value="佐賀県">佐賀県</option>
								<option value="長崎県">長崎県</option>
								<option value="熊本県">熊本県</option>
								<option value="大分県">大分県</option>
								<option value="宮崎県">宮崎県</option>
								<option value="鹿児島県">鹿児島県</option>
								<option value="沖縄県">沖縄県</option>
							</select>
							<!--select prefecture-->
						</div>
						<div class="input-container input-half">
							<input name="District" required="" value="{{$District}}" id="district" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="市区町村">
							<!--select districts-->
						</div>
					</div>
					<!--/form-field-->
					<div class="form-field two-inputs nopd no-btm-border">
						<div class="input-container input-half">
							<input name="Address1" required="" id="SpaceAddr" value="{{$Address1}}" required="" ng-model="signup.addr" type="text" class="ng-pristine ng-untouched ng-invalid-required" aria-required="true" placeholder="番地">
							<!--select towns-->
						</div>
						<div class="input-container input-half">
							<input name="Address2" id="SpaceAddr2" value="{{$Address2}}" ng-model="signup.addr2" type="text" class="ng-pristine ng-untouched" placeholder="建物名・階・部屋番号">
						</div>
					</div>
					<!--/form-field-->
				</div>
				<!--/form-field-->
				<div class="form-field">
					<label for="SpaceTitle">
						<span class="require-mark">*</span>
						スペースがある階
					</label>
					<div class="input-container input-auto-width">
						<div class="input-wraper">
						<?php echo Form::select('LevelFloor',
								[
								'地上' => '地上',
								'地下' => '地下',
						], $space->LevelFloor, ['id' => 'choose_level_floor', 'class' => 'min-w80', 'required' => 'required']);?>
						</div>
						<div class="input-wraper">
							<?php echo Form::text('LevelFloorValue', $space->LevelFloorValue, ['id' => 'level_floor_value', 'required' => 'required'])?>
						</div>
						<span class="input-unit">階</span>
					</div>
				</div>
				<!--/form-field-->
				<div class="form-field col3_wrapper">
					<label for="SpaceTitle">
						<span class="require-mark">*</span>
						スペースタイプと利用可能人数 -
						<img style="" src="{{ URL::asset('images/help.png') }}" class="ttimg" data-title="スペースタイプについて" data-content="<strong>コワーキング</strong><br/>会議室、打ち合わせスペースなどを他の人と共有し、オープンエリアにある共有スペース<br/><strong>オープンデスク</strong><br/>共有スペースの中でデスクなどが決められていないワークスペース<br/><strong>専用デスク</strong><br/>オープンエリアにある専用デスクスペース(1人用)<br/><strong>会議室</strong><br/>会議室用のスペース<br/><strong>セミナースペース</strong><br/>セミナー用のスペース<br/><strong>プライベートオフィス</strong><br/>個人用の個室のオフィス<br/><strong>チームオフィス</strong><br/>複数人用の個室オフィス<br/><strong>オフィス</strong><br/>完全に独立した部屋全体を利用できるオフィス" />
					</label>
					<div class="input-container input-col3">
						<select id="choose_per_type" name="FeeType" required>
							@foreach(Config::get('lp.budgetType') as $bud => $ar )
							<option data-group="{{ $ar['type'] }}" data-fee-group="{{ $ar['fee'] }}" value="{{ $ar['id'] }}" <?php if($space->FeeType == $ar['id']){ echo "selected"; } ?>>{{ $ar['display'] }}</option>
							@endforeach
						</select>
					</div>
					<div class="input-container input-col3">
						<select id="choose_type_of_office" required name="Type" data-label="スペースタイプを選択">
							<option value="" selected="">スペースタイプを選択</option>
							<option value="{{SPACE_FIELD_CORE_WORKING}}">{{SPACE_FIELD_CORE_WORKING}}</option>
							<option data-room-group="room-group-a" value="{{SPACE_FIELD_OPEN_DESK}}">{{SPACE_FIELD_OPEN_DESK}}</option>
							<option data-room-group="room-group-a" value="{{SPACE_FIELD_SHARE_DESK}}">{{SPACE_FIELD_SHARE_DESK}}</option>
							<!--Monthly-->
							<!--Weekly-->
							<option data-group="type-group-b" data-room-group="room-group-a" value="{{SPACE_FIELD_PRIVATE_OFFICE}}">{{SPACE_FIELD_PRIVATE_OFFICE}}</option>
							<option data-group="type-group-b" data-room-group="room-group-a" value={{SPACE_FIELD_TEAM_OFFICE}}>{{SPACE_FIELD_TEAM_OFFICE}}</option>
							<option data-group="type-group-b" value="{{SPACE_FIELD_OFFICE}}">{{SPACE_FIELD_OFFICE}}</option>
							<!--Hourly-->
							<option data-group="type-group-c" value="{{SPACE_FIELD_METTING}}">{{SPACE_FIELD_METTING}}</option>
							<option data-group="type-group-c" value="{{SPACE_FIELD_SEMINAR_SPACE}}">{{SPACE_FIELD_SEMINAR_SPACE}}</option>
						</select>
					</div>
					<div class="input-container input-col3" id="capacity_people_wraper">
						<div class="input_withunit">
							<div class="input-wraper">
								<input type="number" required="" value="{{$space->Capacity}}" name="Capacity" min="1" max="100" id="ty3">
							</div>
							<span class="input-unit">人</span>
						</div>
					</div>
				</div>
				<div class="form-field two-inputs space-area-wraper type-group-sub type-group-c" data-group="type-group-b">
					<div class="input-container input-half">
						<label for="space_area">スペース面積 </label>
						<div class="input_withunit">
							<input type="number" required="" value="{{$space->Area}}" name="Area" min="1" max="100" id="ty3">
							m&sup2;
						</div>
					</div>
				</div>
				<!--/form-field-->
                <!--start if space type is 専用デスク-->
                <div class="form-field col3_wrapper" id="desk_size_wraper">
                <label for="SpaceTitle">
						<span class="require-mark">*</span>
						デスクの大きさ(mm)
					</label>
                    <div class="input-container">
                    <div class="input_cross_size">
							<input type="number" required="" value="{{$space->DeskSizeW}}" name="DeskSizeW" min="1" id="ty3">
							<span class="times_symbol">&times;</span>
							<input type="number" required="" value="{{$space->DeskSizeH}}" name="DeskSizeH" min="1" id="ty3">
						</div>
                    </div>
                </div>
                <!--end if space type is 専用デスク-->
				<div class="form-field">
					<label for="SpaceDesc">
						<span class="require-mark">*</span>
						スペース説明文
					</label>
					<textarea required cols="20" name="Details" id="WorkspaceData_ShortDescription" rows="5" class="space-desc-textarea ng-pristine ng-untouched ng-invalid ng-invalid-required">{{$space->Details}}</textarea>
					<div class="text-length-counter">
						<span>0</span>
						<span>/4000</span>
					</div>
				</div>
				<div class="form-field">
					<label for="EnterDesc">
						<span class="require-mark">*</span>
						How to enter
					</label>
					<textarea required cols="20" name="EnterDetails" id="WorkspaceData_EnterDescription" rows="5" class="space-desc-textarea ng-pristine ng-untouched ng-invalid ng-invalid-required">{{$space->EnDetails}}</textarea>
					<div class="text-length-counter">
						<span>0</span>
						<span>/4000</span>
					</div>
				</div>
				<div class="form-field">
					<label for="ExitDesc">
						<span class="require-mark">*</span>
						How to exit
					</label>
					<textarea required cols="20" name="ExitDetails" id="WorkspaceData_ExitDescription" rows="5" class="space-desc-textarea ng-pristine ng-untouched ng-invalid ng-invalid-required">{{$space->ExDetails}}</textarea>
					<div class="text-length-counter">
						<span>0</span>
						<span>/4000</span>
					</div>
				</div>
				<div class="form-field nopd no-btm-border col3_wrapper">
					<div class="input-container input-col3">
						<label for="SpaceDesc">
							<span class="require-mark">*</span>
							喫煙
						</label>
						<?php echo Form::select('Smoking',
								[
								'室内禁煙(喫煙所無し)' => '室内禁煙(喫煙所無し)',
								'室内禁煙(喫煙所有り)' => '室内禁煙(喫煙所有り)',
								'室内喫煙可' 			=> '室内喫煙可'
																], $space->Smoking, ['id' => 'choose_smoking', 'required' => 'required']);?>
					</div>
					<div class="input-container input-col3">
						<label for="SpaceDesc">
							<span class="require-mark">*</span>
							飲食
						</label>
						<?php echo Form::select('EatIn',
								[
								'飲食不可' => '飲食不可',
								'飲食不可(飲食可のスペース別途有り)' => '飲食不可(飲食可のスペース別途有り)',
								'飲食可' 			=> '飲食可'
																], $space->EatIn, ['id' => 'choose_eat_in', 'required' => 'required']);?>
					</div>
				</div>
				<div class="form-field nopd no-btm-border col3_wrapper">
					<div class="input-container input-col3">
						<label for="SpaceDesc"> 特徴を追加 </label>
						<?php 
						//echo $space->original_point ;
						$space->original_point = explode(",", $space->original_point);
						?>
						<div class="addel">
							@foreach($space->original_point as $key => $val)
							<div class="form-group target">
								<div class="input-group">
									<input name="original_point[]" class="form-control" type="text" value="{{ $val }}">
									<span class="input-group-btn">
										<button type="button" class="btn btn-danger addel-delete">
											<i class="fa fa-remove"></i>
										</button>
									</span>
								</div>
							</div>
							@endforeach
							<button type="button" class="btn btn-success btn-block addel-add">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="hr"></div>
			<fieldset>
				<div class="Signup-sectionHeader">
					<legend class="signup-sectionTitle"> 写真 </legend>
				</div>
				<section class="space-photo-upload">
					<div class="space-setting-content">
						<div class="form-container">
							<div class="form-field two-inputs nopd no-btm-border">
								<div class="input-container input-half">
									<label for="SpaceMainPhoto">
										<span class="require-mark">*</span>
										メイン写真
									</label>
									<div class="edit-gallery-wrapper">
										<div class="edit-gallery-thumbnails edit-main-picture edit-gallery-thumbnails-placeholder">
											<?php 
											$main="";
											$main_id="";
											$thumb_1="";
											$thumb_1_id="";
											$thumb_2="";
											$thumb_2_id="";
											$thumb_3="";
											$thumb_3_id="";
											$thumb_4="";
											$thumb_4_id="";
											$thumb_5="";
											$thumb_5_id="";
											$k=1;
											if($IsEdit=="True")
											{
												$spaceImg= $space->spaceImage->all();
												;
												foreach($spaceImg as $im)
												{
													if($im->Main==1)
													{
														$main=$im->ThumbPath;
														$main_id=$im->id;
													}
													else{
														${"thumb_".$k} = $im->SThumbPath;
														${"thumb_".$k."_id"}=$im->id;
														$k++;
													}
												}
											}
												
											?>
											<div class="edit-gallery-thumbnail-wrapper" image-type="main" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#popover_content_wrapper" style=<?php if(Session::get('space_image')) echo 'background-image:url("'. (Session::get('space_image')) .'?t='. time() .'")'?> <?php if(!empty($main)) echo 'background-image:url("'.($main).'")'?>>
												<input type="hidden" name="dataimage[main]" id="image_main" value="" />
												<?php if($IsEdit=="True"){ ?>
												<input type="hidden" name="dataimage[main_id]" value="<?=$main_id?>" />
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="edit-gallery-buttons" data-toggle="modal" image-type="main" data-target="#popover_content_wrapper">
										<button class="upload-button btn ui-button-text-only yellow-button" role="button" aria-disabled="false">
											<span class="ui-button-text">アップロード</span>
										</button>
										<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
											<span class="ui-button-text">Edit selected</span>
										</button>
									</div>
								</div>
								<!--/input-container-->
								<label for="SpacePhotos">ギャラリー写真 </label>
								<div class="input-container input-half">
									<div class="edit-gallery-wrapper">
										<div class="edit-gallery-thumbnails edit-gallery-thumbnails-placeholder">
											<?php for($i=1; $i<6; $i++) {?>
											<?php 
											$timg = ${"thumb_".$i}; 
											$thumbID = ${"thumb_".$i."_id"};
											?>
											<div class="edit-gallery-thumbnail-wrapper" image-type="thumb_<?php echo $i?>" data-toggle="modal" data-backdrop="static" data-keyboard="false"  data-target="#popover_content_wrapper" style=<?php if(!empty($timg)) echo 'background-image:url("'.($timg).'")'?>>
												<i class="fa fa-times <?php if(empty($timg)) echo 'hide'?>" aria-hidden="true" data-spaceid="{{$space->id}}" data-imageid="{{$thumbID}}"></i>
												<input class="image_thumb" type="hidden" name="dataimage[thumb_<?php echo $i?>]" value="" id="image_thumb_<?php echo $i?>" />
												<?php if($IsEdit=="True"){ ?>
												<input class="image_thumb_id" type="hidden" name="dataimage[thumb_<?php echo $i?>_id]" value="<?=${"thumb_".$i."_id"}?>" />
												<?php } ?>
											</div>
											<?php }?>
										</div>
									</div>
									<div class="edit-gallery-buttons" data-toggle="modal" image-type="thumb_<?=$k?>" isbutton="yes" data-target="#popover_content_wrapper">
										<button class="upload-button btn ui-button-text-only yellow-button" role="button" aria-disabled="false">
											<span class="ui-button-text">アップロード</span>
										</button>
										<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" style="display: none;">
											<span class="ui-button-text">Edit selected</span>
										</button>
									</div>
								</div>
								<!--/input-container-->
							</div>
						</div>
						<!--/form-container-->
					</div>
					<!--/space-setting-content-->
				</section>
			</fieldset>
			<div class="hr"></div>
			<fieldset>
				<div class="Signup-sectionHeader">
					<legend class="signup-sectionTitle"> 金額と期間 </legend>
				</div>
				<div id="hourDivBase" <?php if($space->FeeType == 1){ echo 'style="display:block"'; }else{ echo 'style="display:none"'; } ?>>
					<!--Hourly-->
					<div class="form-field two-inputs nopd no-btm-border" data-fee-group="fee-group-a">
						<div class="input-container input-half">
							<div class="field_col">
								<div class="input_withunit space_price_term fhoc" id="choose_fee_per" <?php if($space->per_hour_status == 1){ echo 'style="display:none;"'; } ?>>
									<label class="label_left">1時間あたり </label>
									<div class="input-wraper">
										<input required="" value="{{$space->HourFee}}" data-value="{{$space->HourFee}}" name="HourFee" id="FeePerHour" required="" ng-model="signup.fee_price_per_hour" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
									</div>
									<span class="input-unit">円</span>
								</div>
							</div>
							<!--/field_col-->
							<!--start flexable setting for week and weekday-->
							<div class="field_col">
								<label style="display: inline;" class="full_label">
									<input type="checkbox" name="per_hour_status" id="per_hour_status_chk" value="1" <?php if($space->per_hour_status == 1){ echo "checked"; } ?> onchange="MychkBoxchk('divshow1',this.id)">
									平日と休日で金額を設定
									<!--Change Price by Weekday and Weekend-->
								</label>
								<img src="{{ URL::asset('images/help.png') }}" class="ttimg" data-title="変動する金額" data-content="平日、土日、祝日にて料金が変動する場合はこちらにチェックし、それぞれの金額を設定して下さい。" />
							</div>
							<div id="divshow1" <?php if(!$space->per_hour_status == 1){ echo 'style="display:none;"'; } ?>>
								<!--/field_col-->
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per">
										<label class="label_left">
											平日
											<!--Weekday-->
										</label>
										<input required="" value="{{$space->HourFeeWeek}}" data-value="" name="HourFeeWeek" id="FeePerHourWeekday" required="" ng-model="signup.fee_price_per_hour_weekday" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
										円/時間
									</div>
								</div>
								<!--/field_col-->
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per">
										<label class="label_left">
											土曜
											<!--Sat-->
										</label>
										<input required="" value="{{$space->HourFeeSat}}" data-value="" name="HourFeeSat" id="FeePerHourSat" required="" ng-model="signup.fee_price_per_hour_sat" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
										円/時間
									</div>
								</div>
								<!--/field_col-->
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per">
										<label class="label_left">
											日曜
											<!--Sun-->
										</label>
										<input required="" value="{{$space->HourFeeSun}}" data-value="" name="HourFeeSun" id="FeePerHourSun" required="" ng-model="signup.fee_price_per_hour_sun" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
										円/時間
									</div>
								</div>
								<!--/field_col-->
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per">
										<label class="label_left">祝日<!--National Holiday--></label>
										<input required="" value="{{$space->HourFeeHoliday}}" data-value="" name="HourFeeHoliday" id="FeePerHourHoliday" required="" ng-model="signup.fee_price_per_hour_holiday" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
										円/時間
									</div>
								</div>
							</div>
							<!--/field_col-->
							<!--/end of flexable setting for week and weekday-->
						</div>
						<!--/input-half-->
						<div class="input-container input-half">
							<div class="field_col">
								<div class="input_withunit space_min_term  " <?php /*if($space->per_hour_status == 1){ echo 'style="display:none;"'; }*/ ?>>
									<label class="label_left">最低利用時間</label>
									<select required data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="HourMinTerm" name="HourMinTerm">
										<option selected="selected" value="1">1時間</option>
										<option value="2">2時間</option>
										<option value="3">3時間</option>
										<option value="4">4時間</option>
									</select>
								</div>
							</div>
							<!--/field_col-->
						</div>
						<!--/input-half-->
					</div>
					<!--/form-field-->
				</div>
				<!--Daily-->
				<div class="form-field two-inputs " data-fee-group="fee-group-b">
					<div class="input-container input-half">
						<div id="dayDivBase" <?php if($space->FeeType == 2){ echo 'style="display:block"'; }else{ echo 'style="display:none"'; } ?>>
							<div class="field_col">
								<div class="input_withunit space_price_term fhoc" id="choose_fee_per_day" <?php if($space->per_day_status == 1){ echo 'style="display:none;"'; } ?>>
									<label class="label_left">1日あたり</label>
									<input required="" value="{{$space->DayFee}}" name="DayFee" id="FeePerDay" data-value="{{$space->DayFee}}" value="{{$space->DayFee}}" required="" ng-model="signup.fee_price_per_day" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
									円
								</div>
							</div>
							<!--/field_col-->
							<!--start flexable setting for week and weekday-->
							<div class="field_col">
								<label style="display: inline;" class="full_label">
									<input type="checkbox" name="per_day_status" id="per_day_status_chk" value="1" <?php if($space->per_day_status == 1){ echo "checked"; } ?> onchange="MychkBoxchk('divshow2',this.id)">
									平日と休日で金額を設定
									<!--Change Price by Weekday and Weekend-->
								</label>
								<img style="margin-top: 3px;" src="{{ URL::asset('images/help.png') }}" class="ttimg" data-title="Title per day" data-content="Contents per day..." />
							</div>
							<!--/field_col-->
							<div id="divshow2" <?php if($space->per_day_status == 0){ echo 'style="display:none"'; } ?>>
								<div class="input_withunit space_price_term" id="choose_fee_per_day">
									<label class="label_left">
										平日
										<!--Weekday-->
									</label>
									<input required="" value="{{$space->DayFeeWeekday}}" name="DayFeeWeekday" id="FeePerDayWeekday" required="" ng-model="signup.fee_price_per_day_weekday" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
									円/日
								</div>
								<!--/field_col-->
								<div class="field_col">
									<div class="input_withunit space_price_term" id="choose_fee_per_day">
										<label class="label_left">
											土曜
											<!--Sat-->
										</label>
										<input required="" value="{{$space->DayFeeSat}}" name="DayFeeSat" id="FeePerDaySat" required="" ng-model="signup.fee_price_per_day_sat" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
										円/日
									</div>
									<!--/field_col-->
									<div class="field_col">
										<div class="input_withunit space_price_term" id="choose_fee_per_day">
											<label class="label_left">
												日曜
												<!--Sun-->
											</label>
											<input required="" value="{{$space->DayFeeSun}}" name="DayFeeSun" id="FeePerDaySun" required="" ng-model="signup.fee_price_per_day_sun" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
											円/日
										</div>
										<!--/field_col-->
										<div class="field_col">
											<div class="input_withunit space_price_term" id="choose_fee_per_day">
												<label class="label_left">
													祝日
													<!--National Holiday-->
												</label>
												<input required="" value="{{$space->DayFeeHoliday}}" name="DayFeeHoliday" id="FeePerDayHoliday" required="" ng-model="signup.fee_price_per_day_holiday" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
												円/日
											</div>
											<!--/field_col-->
										</div>
									</div>
									<!--/input-half-->
									<div class="input-container input-half">
										<div class="field_col"></div>
										<!--/field_col-->
									</div>
									<!--/input-half-->
								</div>
								<!--/form-field-->
							</div>
						</div>
					</div>
					<!--Weekly-->
					<div class="form-field two-inputs fee-group-sub" data-fee-group="fee-group-c">
						<div class="input-container input-half">
							<div class="field_col">
								<div class="input_withunit space_price_term" id="choose_fee_per_week">
									<label class="label_left">1週間あたり</label>
									<input required="" name="WeekFee" id="FeePerWeek" value="{{$space->WeekFee}}" data-value="{{$space->WeekFee}}" required="" ng-model="signup.fee_price_per_week" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
									円
								</div>
							</div>
							<!--/field_col-->
						</div>
						<!--/input-half-->
						<div class="input-container input-half">
							<div class="field_col">
								<div class="input_withunit space_min_term">
									<label class="label_left">最低利用期間</label>
									<select data-bind="value: MinimumBookingLength" required data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="WeekMinTerm" name="WeekMinTerm">
										<option selected="selected" value="1">1週間</option>
										<option value="2">2週間</option>
									</select>
								</div>
							</div>
							<!--/field_col-->
						</div>
						<!--/input-half-->
					</div>
					<!--/form-field-->
					<!--Monthly-->
					<div class="form-field two-inputs no-btm-border fee-group-sub" data-fee-group="fee-group-d">
						<div class="input-container input-half">
							<div class="field_col">
								<div class="input_withunit space_price_term" id="choose_fee_per_month">
									<label class="label_left">1ヶ月あたり</label>
									<input required="" name="MonthFee" id="FeePerMonth" value="{{$space->MonthFee}}" data-value="{{$space->MonthFee}}" required="" ng-model="signup.fee_price_per_month" type="text" class="ng-invalid" aria-invalid="true" placeholder="">
									円
								</div>
							</div>
							<!--/field_col-->
						</div>
						<!--/input-half-->
						<div class="input-container input-half">
							<div class="field_col">
								<div class="input_withunit space_min_term">
									<label class="label_left">最低利用期間</label>
									<select required data-bind="value: MinimumBookingLength" data-val="true" data-val-number="The field MinimumBookingLength must be a number." data-val-required="The MinimumBookingLength field is required." id="MonthMinTerm" name="MonthMinTerm">
										<option selected="selected" value="1">1ヶ月</option>
										<option value="3">3ヶ月</option>
										<option value="6">6ヶ月</option>
										<option value="12">12ヶ月</option>
									</select>
								</div>
							</div>
							<!--/field_col-->
						</div>
						<!--/input-half-->
					</div>
					<!--/form-field-->
			
			</fieldset>
			<div class="hr"></div>
			<fieldset>
				<div class="Signup-sectionHeader">
					<legend class="signup-sectionTitle">最終予約受付</legend>
				</div>
				<div class="input-container input-half input-auto-width">
					<div class="field_col">
						<div class="form-field">
							<div class="input_withunit">
								<label style="display: inline;" for="last-book">
									<span class="require-mark">*</span>
									利用開始日前の最終予約受付期間
									<img style="" src="{{ URL::asset('images/help.png') }}" class="ttimg" data-title="最終予約受付期間について" data-content="利用開始日前に何時間前、日、週間、ヶ月前に最短で予約できるかの設定。<br/>例)1時間前と設定した場合、利用開始時間が14時であれば、13時までの予約受付完了にて予約ができる。<br/>※予約確認できる余裕をもった時間数や日数にて設定して下さい" />
									<span class="help">*利用者が利用開始日前に予約できる最短期間</span>
								</label>
								<div class="input-wraper">
									<input required="" data-value="" name="LastBook" id="LastBook" ng-model="last_book" value='{{$space->LastBook}}' type="text" class="ng-invalid" aria-invalid="true" placeholder="" aria-required="true">
								</div>
								<select id="LastBookUnit" class="min-w80 valid" required name="LastBookUnit" aria-required="true" aria-invalid="false">
									<option value="1" @if($space->LastBookUnit==1)selected="selected" @endif>時間</option>
									<option value="2" @if($space->LastBookUnit==2)selected="selected" @endif>日</option>
									<option value="3" @if($space->LastBookUnit==3)selected="selected" @endif>週間</option>
									<option value="4" @if($space->LastBookUnit==4)selected="selected" @endif>ヶ月</option>
								</select>
								前
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="hr"></div>
			<fieldset>
				<div class="Signup-sectionHeader">
					<legend class="signup-sectionTitle"> 基本利用可能時間帯 <img style="margin-top: 3px;" src="{{ URL::asset('images/help.png') }}" class="ttimg" data-title="利用可能時間帯" data-content="曜日ごとに目安となる利用可能時間帯を設定して下さい。<br/>※実際の利用提供時間はカレンダーにて別途設定となります。" /></legend>
				</div>
				<div class="form-field time-to-use-signup no-btm-border">
					<div class="input-container">
						<div class="space-setting-content" id="opentime">
							<div class="form-container">
								<div class="form-field nopd">
									<table class="time-slot-table">
										<thead>
											<tr>
												<th>曜日</th>
												<th colspan="3">時間帯</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											for($i = 1; $i <= 7; $i++)
											{
												$date = strftime('%A', strtotime("Sunday + $i Days"));
												$day_name = date('l', strtotime("Sunday + $i Days"));
												?>
											<tr data-date="<?php echo ($day_name)?>" class="date-row">
												<td class="daystring">{{Config::get("lp.daystring.$date")}}</td>
												<td class="inplaceedit">
													<?php $col1=$date."StartTime";
																	$col2=$date."EndTime"; ?>
													<div class="display hour-column">@if($IsEdit=="True") {{$space->$col1}}-{{$space->$col2}} @else 9:00 AM - 5:00 PM @endif</div>
													<div class="edit">
														<span class="edit-hour-block" style="display: none;"> </span>
														<span class="edit-closed-text" style="display: none;"> 終日利用不可 </span>
														<span class="edit-open-text" style="display: none;"> 24時間利用可能 </span>
													</div>
												</td>
												<td class="checkbutton-cell edit-closed">
													終日利用不可
													<span class="checkmark"></span>
													<input type="checkbox" value="Yes" name="isClosed<?php echo $day_name?>" style="display: none" />
												</td>
												<td class="checkbutton-cell edit-open">
													24時間利用可能
													<span class="checkmark"></span>
													<input type="checkbox" value="Yes" name="isOpen24<?php echo $day_name?>" style="display: none" />
												</td>
											</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
								<!--/form-field-->
							</div>
							<!--/form-container-->
						</div>
						<!--/space-setting-content-->
					</div>
					<!--/input-container-->
				</div>
				<!--/form-field-->
			</fieldset>
			<div class="hr"></div>
			<fieldset>
				<div class="Signup-sectionHeader">
					<legend class="signup-sectionTitle"> スペースシェアに含まれる設備 </legend>
				</div>
				<div class="form-field quater-inputs space-fac">
					<div class="input-container input-quater">
						<label for="num-desk">デスク </label>
						<span class="field-number-input-withunit">
							<input type="number" value="{{$space->NumOfDesk==0 ? '':$space->NumOfDesk}}" name="NumOfDesk" min="1" max="50">
							台
						</span>
					</div>
					<div class="input-container input-quater">
						<label for="num-chair">イス </label>
						<span class="field-number-input-withunit">
							<input type="number" name="NumOfChair" value="{{$space->NumOfChair==0 ? '':$space->NumOfChair}}" min="1" max="50">
							脚
						</span>
					</div>
					<div class="input-container input-quater">
						<label for="num-board">ボード </label>
						<span class="field-number-input-withunit">
							<input type="number" name="NumOfBoard" value="{{$space->NumOfBoard==0 ? '':$space->NumOfBoard}}" min="1" max="50">
							台
						</span>
					</div>
					<div class="input-container input-quater">
						<label for="num-largedesk">複数人用デスク </label>
						<span class="field-number-input-withunit">
							<input type="number" name="NumOfTable" value="{{$space->NumOfTable==0 ? '':$space->NumOfTable}}" min="1" max="50">
							台
						</span>
					</div>
				</div>
				<!--/form-field-->
				<div class="form-field no-btm-border no-btm-pad space-other-fac">
					<div class="input-container">
						<label for="OtherFac">その他設備 </label>
						<div class="checkbox-array">
							<span class="checkbox">
								<input type="checkbox" name="OtherFacilities[]" class="custom-checkbox" value="wi-fi" <?php if (strpos($space->OtherFacilities, 'wi-fi') !== false) { echo 'checked';}  ?> data-labelauty="Wifi|Wifi">
							</span>
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'プリンター') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="プリンター" data-labelauty="プリンター|プリンター">
							</span>
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, 'プロジェクター') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="プロジェクター" data-labelauty="プロジェクター|プロジェクター">
							</span>
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '自動販売機') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="自動販売機" data-labelauty="自動販売機|自動販売機">
							</span>
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '男女別トイレ') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="男女別トイレ" data-labelauty="男女別トイレ|男女別トイレ">
							</span>
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" <?php if (strpos($space->OtherFacilities, '喫煙所') !== false) { echo 'checked';}  ?> name="OtherFacilities[]" value="喫煙所" data-labelauty="喫煙所|喫煙所">
							</span>
						</div>
						<!--/checkbox-array-->
					</div>
				</div>
				<!--/form-field-->
				<div class="form-field no-btm-border no-btm-pad space-bld-fac">
					<div class="input-container">
						<label for="OtherBldFac">
							ビル設備
							<span class="help">*駐車場は利用可能な場合のみご選択ください。</span>
						</label>
						<div class="checkbox-array">
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" name="OtherFacilities[]" value="駐車場" <?php if (strpos($space->OtherFacilities, '駐車場') !== false) { echo 'checked';}  ?> data-labelauty="駐車場|駐車場">
							</span>
							<span class="checkbox">
								<input type="checkbox" class="custom-checkbox" name="OtherFacilities[]" value="エレベーター" <?php if (strpos($space->OtherFacilities, 'エレベーター') !== false) { echo 'checked';}  ?> data-labelauty="エレベーター|エレベーター">
							</span>
						</div>
					</div>
				</div>
				<!--/form-field-->
			</fieldset>
			<div class="hr"></div>
		</div>
	</div>
</div>

