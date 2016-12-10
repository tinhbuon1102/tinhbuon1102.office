jQuery(function($){
	var config = {
		      '.chosen-select'           : {},
		      '.chosen-select-deselect'  : {allow_single_deselect:true},
		      '.chosen-select-no-single' : {disable_search_threshold:10},
		      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		      '.chosen-select-width'     : {width:"95%"}
		    }
    for (var selector in config) {
      jQuery(selector).chosen(config[selector]);
    }
	
	$(".input-container.iconbutton").click(function(){
    	$(".input-container.iconbutton:not(this)").removeClass('checked');
    	$(this).toggleClass("checked");
    	
    	$('.space_price_term').hide();
    	if($('.iconbutton-metting').hasClass('checked') || $('.iconbutton-semiar-space').hasClass('checked'))
    	{
			$('#choose_fee_per_hour').show();
        }
    	else {
    		$('.space_price_term').show();
			$('#choose_fee_per_hour').hide();
    	}
    });


	$('body').on('change', '#choose_per_type', function(){
		var selectedGroup = $(this).find('option:selected').attr('data-group');
		var selectedFeeGroup = $(this).find('option:selected').attr('data-fee-group');

		//Show hide type of office drop down
    	$('#choose_type_of_office option[data-group="type-group-b"]').hide();
    	$('#choose_type_of_office option[data-group="type-group-c"]').hide();
    	$('#choose_type_of_office option[data-group="'+selectedGroup+'"]').show();

    	// Show hide fee price term
    	$('.fee-group-sub').hide();
    	$('.fee-group-sub').find('input').val('');
    	selectedFeeGroup = selectedFeeGroup.split(',');
    	$.each(selectedFeeGroup, function(index, group){
    		$('.fee-group-sub[data-fee-group="'+group+'"]').show();
    		$('.fee-group-sub[data-fee-group="'+group+'"]').find('input').val($('.fee-group-sub[data-fee-group="'+group+'"]').find('input').data('value'));
        })
    });

    $('body').on('change', '#choose_type_of_office', function(){
    	var selectedGroup = $(this).find('option:selected').attr('data-group');
    	var selectedRoomGroup = $(this).find('option:selected').attr('data-room-group');
        // Show/hide capacity people field
    	if($(this).val() == SPACE_FIELD_SHARE_DESK)
		{
			$('#capacity_people_wraper').hide();
			$('#desk_size_wraper').show();
		}
		else {
			$('#capacity_people_wraper').show();
			$('#desk_size_wraper').hide();
		}

		// Show hide Space area input field
		$('.type-group-sub').hide();
		$('.type-group-sub[data-group="'+selectedGroup+'"]').show();
		$('.type-group-sub.' + selectedGroup).show();

		// Show hide metting room input field
		$('.room-group-sub').hide();
		$('.room-group-sub[data-room-group="'+selectedRoomGroup+'"]').show();
    });

    // trigger change
    $('#choose_per_type').trigger('change');
    $('#choose_type_of_office').trigger('change');

    $('body').on('click', 'form#shareinfo #saveBasicInfo', function(e){
    	e.preventDefault();
    	$('form#shareinfo').find('input[type="text"]:hidden').val('');
    	$('form#shareinfo').find('input[type="number"]:hidden').val('');
    	$('form#shareinfo').submit();
    });
    
    $('body').on('keyup change', 'input#zip', function(){
    	var zip1 = $.trim($(this).val());
        var zipcode = zip1;
 
        $.ajax({
            type: "post",
            url: SITE_URL + "dataAddress/api.php",
            data: JSON.stringify(zipcode),
            crossDomain: false,
            dataType : "jsonp",
            scriptCharset: 'utf-8'
        }).done(function(data){
            if(data[0] == ""){
            } else {
            	$('#Prefecture').val(data[0]);
                $('#District').val(data[1]);
                $('#prefecture').val(data[0]);
                $('#district').val(data[1]);
                $('#city').val(data[1]);
                $('#City').val(data[1]);
                var address1 = $('input[name="Address1"]').val();
                address1 = address1.replace(data[2], '');
                $('input[name="Address1"]').val(data[2] + address1);
            }
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        });
	});
    
    // Convert kana
 // Auto kana
    if (typeof $.fn.autoKana != 'undefined')
    {
		$.fn.autoKana('#LastName', '#LastNameKana', {katakana:false});
		$.fn.autoKana('#FirstName', '#FirstNameKana', {katakana:false});
    }
    
    $('#preview_content_wrapper').on('hidden.bs.modal', function (e) {
    	$('html').css('overflow', 'auto');
    });
    
    $('body').on('click', '#previewBasicInfo', function(){
    	result = false;
    	if ($('#shareinfo').valid())
    	{
    		if (!$('#image_main').val() && !jQuery('[name="dataimage[main_id]"]').val()) {
                alert(typeof missingImageAlert == 'string' ? missingImageAlert : 'Please add image for space !');
                $('html,body').animate({ scrollTop: $('.edit-gallery-wrapper').offset().top  - 200}, 'slow');
                return false;
            }
    		
    		$('html').css('overflow', 'hidden');
        	$('body').LoadingOverlay("show");
        	
    		$.ajax({
                type: "post",
                url: $('#shareinfo').attr('action') + '?action=preview',
                data: $('#shareinfo').serialize(),
                crossDomain: false,
                dataType : "json",
                scriptCharset: 'utf-8'
            }).done(function(response){
            	result = true;
            	$('body').LoadingOverlay("hide");
            	
            	$('#preview_content_wrapper').css('overflow-y', 'hidden');
            	$('#preview_content_wrapper .modal-dialog').css('width', '100%').css('margin', 0);
            	$('#preview_content_wrapper .modal-body').css('width', '100%').css('padding', 0);
            	
            	$('#shareinfo').attr('action', SITE_URL + 'ShareUser/ShareInfo/' + response.HashID);
            	$('#preview_content_wrapper .modal-body').html('<iframe width="100%" height="'+ $(window).height() +'" src="'+ response.url +'"></iframe>')
            	$('#preview_content_wrapper').modal({ 
            		show: true,
            	})
            }).fail(function(XMLHttpRequest, textStatus, errorThrown){
            	result = false;
            	$('body').LoadingOverlay("hide");
            });
    	}
    	else {
    		$('#shareinfo').find('select.error:visible:first, input.error:visible:first, textarea.error:visible:first').focus();
    	}
    	return result;
    })
});