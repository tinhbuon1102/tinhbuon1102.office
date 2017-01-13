jQuery(document).ready(function(){

	jQuery('.chat_head').click(function(){
		
		if ( localStorage.chat=='ihide' ) {
			localStorage.setItem("chat", "");
		}
		else{
			localStorage.setItem("chat", "ihide");		
		}
		jQuery('.chat_body').slideToggle('slow');
	});
		//jQuery('.msg_head').click(function(){

	jQuery('.msg_container').on('click', '.msg_head', function() {
		jQuery(this).siblings('.msg_wrap').slideToggle('slow');
	});
	
	//jQuery('.close').click(function(){
		jQuery('.msg_container').on('click', '.chat_close', function() {

		jQuery(this).parents('.msg_box').hide();
	});
	
	jQuery('.user').click(function(){
		var userElement = jQuery(this);
		var id=jQuery(this).data('id');
		var name=jQuery(this).data('name');
		var cid=jQuery(this).data('cid');
		var whichuser=jQuery(this).data('whichuser');
		var online=jQuery(this).data('online');
		
		if(jQuery("#msg_box_" + id).length == 0 && !userElement.hasClass('clicking')) {
			userElement.addClass('clicking');
			if(whichuser=='user1')
			{
					var url='/ShareUser/Dashboard/GetInstantMessage/'+cid;

			}
			else
			{
					var url='/RentUser/Dashboard/GetInstantMessage/'+cid;

			}
			jQuery.get(
					url,
					function(data) {
					jQuery(".msg-scroll").append(getChat(id,name,data,whichuser,online));
					jQuery("#msg_box_" + id +" .msg_body").scrollTop(jQuery("#msg_box_" + id +" .msg_body")[0].scrollHeight);
					userElement.removeClass('clicking');
			}
					
				);
			
		}
		else{	
				jQuery("#msg_box_" + id).show();
			jQuery("#msg_box_" + id + " .msg_wrap").show();
			jQuery("#msg_box_" + id).insertAfter(jQuery(".msg_box").last());
			}
	});
	
	//jQuery('textarea').keypress(	function(e){
    	jQuery('.msg_container').on('keypress', 'textarea', function(e) {

        if (e.keyCode == 13) {
            e.preventDefault();
            var msg = urlify(jQuery(this).val());
			jQuery(this).val('');
			var id=jQuery(this).data('id');
			var whichuser=jQuery(this).data('whichuser');
			if(msg!='')
			{
			//jQuery('<div class="msg_b">'+msg+'</div>').insertBefore('.msg_push');
			
				if(whichuser=='user1')
				{
						var url='/ShareUser/Dashboard/SendMessage';

				}
				else
				{
						var url='/RentUser/Dashboard/SendMessage';

				}
			jQuery(this).parent().siblings('.msg_body').append('<div class="msg_me">'+msg+'</div>');
					jQuery(this).parent().siblings('.msg_body').scrollTop(jQuery(this).parent().siblings('.msg_body')[0].scrollHeight);
			
			jQuery.post(url, {text: msg, id: id}, function()
				{
					
				});
		}	
	   }
    });

	jQuery('.msg_container').on('click', '.iattach', function() {
		jQuery(this).siblings('.imgupload').trigger('click');
	});

	jQuery('.msg_container').on('click', '.has-settings-icon', function(e) {
		jQuery(this).siblings('.dropdown-menu').toggle();
			});
	jQuery('.msg_container').on('click', '.chatbox-controls', function(e) {
		
		e.stopPropagation();
	});
	jQuery('.msg_container').on('change', '.imgupload', function() {
		var file_data = jQuery(".imgupload").prop("files")[0];   // Getting the properties of file from file field
        var form_data = new FormData();                  // Creating object of FormData class
        form_data.append("file", file_data);              // Adding extra parameters to form_data
		
		var id=jQuery(this).siblings('.msg_input').data('id');
		var whichuser=jQuery(this).siblings('.msg_input').data('whichuser');
		
		form_data.append("file", file_data);
		form_data.append("id", id);
				if(whichuser=='user1')
				{
						var url='/ShareUser/Dashboard/SendFile';

				}
				else
				{
						var url='/RentUser/Dashboard/SendFile';

				}
				jQuery("#msg_box_"+id+" .msg_wrap .msg_footer .iloader").show();
				jQuery("#msg_box_"+id+" .msg_wrap .msg_footer .iattach").hide();
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
				
					jQuery("#msg_box_"+id+" .msg_wrap .msg_body").append('<div class="msg_me">'+data.responseText+'</div>');
					jQuery("#msg_box_"+id+" .msg_wrap .msg_body").scrollTop(jQuery("#msg_box_"+id+" .msg_wrap .msg_body")[0].scrollHeight);  
						jQuery("#msg_box_"+id+" .msg_wrap .msg_footer .iloader").hide();
				jQuery("#msg_box_"+id+" .msg_wrap .msg_footer .iattach").show();
				//	jQuery(this).closest('.msg_body').append('<div class="msg_me">'+data+'</div>');
				//	jQuery(this).closest('.msg_body').scrollTop(jQuery(this).parent().siblings('.msg_body')[0].scrollHeight);               
            }
        })
	});
	

});
function getChat(id,name,data,whichuser,online)
	{
		//online = online ? online : 'online';
	
			if(whichuser=='user1')
				{
						var url='/ShareUser/Dashboard/Message/'+id;

				}
				else
				{
						var url='/RentUser/Dashboard/Message/'+id;

				}
			
			var a='<div class="msg_box" id="msg_box_'+id+'"><div class="chatbox-inner"><div class="msg_head"><div class="msg_head_inner"><span class="chatbox-contact-status online-status" data-size="large" data-status="'+online+'"></span><div class="chatbox-header-content"><a class="chatbox-contact-username">'+name+'</a><span class="chatbox-controls thread-actions"><span class="chatbox-controls-inner"><button class="chatbox-controls-button chat_close"><i class="fa fa-times" aria-hidden="true"></i></button><button class="chatbox-controls-button has-settings-icon" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"  ></i></button><ul class="dropdown-menu"> <li><a href="'+url+'" style="text-align:left;">メッセージボックスを開く</a></li></ul></span></span></div></div></div><div class="msg_wrap"><div class="msg_body">'+data+'	<div class="msg_push"></div></div><div class="msg_footer"><textarea class="msg_input" rows="4" data-id="'+id+'" data-whichuser="'+whichuser+'"></textarea><i class="fa fa-paperclip iattach" aria-hidden="true"></i><input type="file" class="imgupload" style="display:none;"/><img src="/chatajax.gif" style="display:none" class="iloader"></div></div></div></div>';
					jQuery(".has-settings-icon").dropdown();
			return(a);
			
	}	