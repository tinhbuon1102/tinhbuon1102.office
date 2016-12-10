if (jQuery.fn.dataTableExt)
{
	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
		"formatted-num-pre" : function(a) {
			a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
			return parseFloat(a);
		},

		"formatted-num-asc" : function(a, b) {
			return a - b;
		},

		"formatted-num-desc" : function(a, b) {
			return b - a;
		}
	});

}

(function($) {
var re = /([^&=]+)=?([^&]*)/g;
var decodeRE = /\+/g;  // Regex for replacing addition symbol with a space
var decode = function (str) {return decodeURIComponent( str.replace(decodeRE, " ") );};
$.parseParams = function(query) {
    var params = {}, e;
    while ( e = re.exec(query) ) { 
        var k = decode( e[1] ), v = decode( e[2] );
        if (k.substring(k.length - 2) === '[]') {
            k = k.substring(0, k.length - 2);
            (params[k] || (params[k] = [])).push(v);
        }
        else params[k] = v;
    }
    return params;
};
})(jQuery);

jQuery(function($){
	
	/*$(".ttimg").click( function(){
		
	});*/
	$(".ttimg").webuiPopover();
	if( $("#WorkspaceData_ShortDescription").length ){
		var dt = jQuery("#WorkspaceData_ShortDescription").val();
		jQuery(".text-length-counter span:first").empty().text(dt.length);
	}
	function updateCount ()
    {
        var qText = jQuery("#WorkspaceData_ShortDescription").val();
       if(qText.length < 4000){
           jQuery(".text-length-counter span:first").empty().text(qText.length);
       }else{
		   var nt = qText.substr(0, 4000);
		   jQuery("#WorkspaceData_ShortDescription").val(nt);
           jQuery(".text-length-counter span:first").empty().text(nt.length);
       }
    }
	
	$("#WorkspaceData_ShortDescription").keyup(function () {
        updateCount();
    });
    $("#WorkspaceData_ShortDescription").keypress(function () {
        updateCount();
    });
    $("#WorkspaceData_ShortDescription").keydown(function () {
        updateCount();
    });
	
	if( $(".chat_body").is(":visible") ){
			$(".search").show();
		}else{
			$(".search").hide();
		}
	$(".chat_head").click( function(){
		if( $(".chat_body").is(":visible") ){
			$(".search").hide();
		}else{
			$(".search").show();
		}
	});
	
	function matchHeightTable()
	{
		if (jQuery('.js-matchHeight').length)
            jQuery('.js-matchHeight').matchHeight();
	}
	
	if ($('.time-slot-table').length)
	{
		var minute = 0;
		var hour_AM = [];
		var hour_PM = [];
		var hour_select = $('<select class="hour_select" style="display: none"></select>').appendTo('body');
		for(i=0; i<=12; i++)
		{
			var str_number = i.toString();
			str_number = str_number + ':00';
			
			hour_AM.push(str_number + ' AM');
			hour_PM.push(str_number + ' PM');
			
//			for(j = 0; j <= 4; j++ )
//			{
//				minute = j * 15;
//				minute = minute == 60 ? 0 : minute;
//				minute = minute.toString();
//				minute = minute.length == 1 ? ("0" + minute) : minute; 
//				
//				var str_number = i.toString();
////				str_number = str_number.length == 1 ? ("0" + str_number) : str_number; 
//				str_number = str_number + ':' + minute;
//				
//				hour_AM.push(str_number + ' AM');
//				hour_PM.push(str_number + ' PM');
//			}
			
		}

		$.each(hour_AM, function(index, value){
			hour_select.append('<option value="'+ value +'">'+ value + '</option>')
		})
		
		$.each(hour_PM, function(index, value){
			hour_select.append('<option value="'+ value +'">'+ value + '</option>')
		})
		
		$('body').on('click', '.hour-column', function(e){
			e.stopPropagation();
			
			// Return if it is closed or open247
			var dateRow = $(this).closest('tr');
			var dayName = dateRow.attr('data-date');
			
			if (dateRow.find('.checkbutton-cell.checked').length) return ;
			
			$(this).hide();
			
			var wraper = $(this).closest('.inplaceedit');
			var hour_block = wraper.find('.edit-hour-block');
			
			var hour_select_from = hour_block.find('.hour_select.hour-from');
			var hour_select_to = hour_block.find('.hour_select.hour-to');
			
			hour_block.show();
			hour_select_from.show();
			hour_select_to.show();
		});
		
		function generateAllTimeSelector(){
			$('.hour-column').each(function(){
				// Return if it is closed or open247
				var dateRow = $(this).closest('tr');
				var dayName = dateRow.attr('data-date');
				
				var hour_value = $(this).text().trim();
				var hour_value_array = hour_value.split('-');
				var hour_value_from = hour_value_array[0].trim();
				var hour_value_to = hour_value_array[1].trim();
					
				var wraper = $(this).closest('.inplaceedit');
				var hour_block = wraper.find('.edit-hour-block');
				
				var hour_select_from = hour_select.clone();
				var hour_select_to = hour_select.clone();
				
				hour_select_from.attr('name', dayName + 'StartTime');
				hour_select_to.attr('name', dayName + 'EndTime');
				
				hour_select_from.attr('id', dayName + 'StartTime');
				hour_select_to.attr('id', dayName + 'EndTime');
				
				hour_select_from.addClass('hour-from');
				hour_select_to.addClass('hour-to');
				
				hour_select_from.val(hour_value_from);
				hour_select_to.val(hour_value_to);
				
				hour_block.html('');
				hour_block.append(hour_select_from);
				hour_block.append(' - ');
				hour_block.append(hour_select_to);
				
			});
		}
		generateAllTimeSelector();
		
		// If an event gets to the body
		$("body").click(function(){
			$(".hour-column").each(function(){
				if ($(this).is(':hidden') && $(this).closest('tr').find('.checked').length == 0)
				{
					$(this).show();
					$('.edit-hour-block').hide();
					
					var wraper = $(this).closest('.inplaceedit');
					if (wraper.find('.hour-from').length && wraper.find('.hour-to').length)
					{
						var hour_value_from = wraper.find('.hour-from').val();
						var hour_value_to = wraper.find('.hour-to').val()
						
						wraper.find('.hour-column').text(hour_value_from + ' - ' + hour_value_to);
					}
				}
			})
		});

		// Prevent events from getting pass .popup
		$("body").on('click', '.inplaceedit .edit', function(e){
			e.stopPropagation();
		});
		
		$("body").on('click', '.checkbutton-cell', function(e){
			e.stopPropagation();
			
			var wraper = $(this).closest('tr');
			var td = $(this).closest('td');
			wraper.find('td').not(td).removeClass('checked');
			wraper.find('td').not(td).find('.checked').removeClass('checked');
			
			wraper.find('td').not(td).find('input[type="checkbox"]').prop('checked', false);
			
			wraper.find('.edit-hour-block').hide();
			
			if ($(this).hasClass('edit-closed'))
			{
				wraper.find('.edit-open-text').hide();
				wraper.find('.edit-closed-text').toggle();
			}else if ($(this).hasClass('edit-open'))
			{
				wraper.find('.edit-closed-text').hide();
				wraper.find('.edit-open-text').toggle();
			}
			
			$(this).toggleClass('checked');
			$(this).find('.checkmark').toggleClass('checked');
			$(this).find('input[type="checkbox"]').prop('checked', $(this).hasClass('checked'));
			
			
			if ($(this).find('.checkmark').hasClass('checked'))
			{
				wraper.find('.hour-column').hide();
			}else {
				wraper.find('.hour-column').show();
			}
			
		});
	}
	
	// Event for price
    jQuery("body").on('change', '#choose_budget_per', function(){
        jQuery(".budget-price").addClass('hide');
        jQuery('#' + $("#choose_budget_per option:selected").attr("class")).removeClass("hide");
        jQuery('#choose_budget_per_ option.budget-price1:not(.hide):eq(0)').attr('selected', true);
    });
	
	// Function for profile button
	$('body').on('click', 'a.profile-btn', function(){
		if ($(this).hasClass('view-profile-btn'))
		{
			$('.cancel-button:visible').click();
		}
		$('a.profile-btn').toggle();
		$('a.profile-job-btn').toggle();
		
		if ($('#profileImageUploader').length)
		{
			$('#profileImageUploader').toggle();
			$('.cover-image-upload-trigger').toggle();
			$('.imgareaselect-outer').remove();
			$('.imgareaselect-selection').parent('div').remove();
		}
		
		$('.portfolio-header').toggle();
		$('.portfolio-add-item-wraper').toggle();
		
		// Hide all editing block
	});
	
	if (typeof $.magnificPopup != undefined && $('.ajax-popup-link').length)
	{
		$('.ajax-popup-link').magnificPopup({
	    	  type: 'ajax'
		});
	}
	
	if ($('.mosaic-block').length )
		$('.mosaic-block').mosaic();	
	
	$('body').on('click', '.ajax-popup-link-close', function(e){
		jQuery('.ajax-popup-link').magnificPopup('close');
	});
	
	
	$('body').on('click', 'a.profile-job-btn', function(){
		$(this).closest('.editable-block-wraper').find('.editable-block').toggle();
		matchHeightTable();
		$('.profile-require-basic.js-matchHeight').height('auto');
	});
	
	
	$('.toggle_button').click(function(e){
		e.preventDefault();
		
		if ($(this).hasClass('save-button') && $(this).hasClass('ui-button-text-only'))
		{
			var text = $(this).closest('.editting-block').find('textarea').val();
			$(this).closest('.editable-block-wraper').find('.editable-block:hidden .edit-content').text(text);
		}
		
		$($(this).attr('bind-toggle')).each(function(){
			$(this).toggle();
		});
		matchHeightTable();
	});
	
	if ($('[data-toggle="popover"]').length)
	{
		$('[data-toggle="popover"]').popover({ 
		});
	}
	
	$('#filters-button').click(function(){
		$('#SpaceFilters').toggle(); 
		$('.reccomend-list').toggle();
	});
	
	
	$('.workspace-actions-wrapper a').click(function(e){
		e.stopPropagation();
		var el = $(this).parent().find('.workspace-actions-popup'); 
		if( el.is(":visible") ){
			el.hide();
		}else{
		    $('.workspace-actions-popup').hide();
			el.show();
		}
	});
	
	$(document).click(function(){
		 $('.workspace-actions-popup').hide();
	});
	
	var l = window.location.href.replace(/&?e=([^&]$|[^&]*)/i, "");
	if( l.indexOf("/Reservation/View/") != -1){
		var ind = l.indexOf("/Reservation/View/");
		ind = ind + 12;
		var pi = l.substr(ind);
		var fl = l.replace(pi, '');
		l = fl;
		
	}
	if( l.indexOf("/EditBook/") != -1){
		var ind = l.indexOf("/EditBook/");
		ind = ind;
		var pi = l.substr(ind);
		var fl = l.replace(pi, '/BookList');
		l = fl;
		
	}
	
	if( l.indexOf("/Dashboard/editspace/") != -1){
		var ind = l.indexOf("/Dashboard/editspace/");
		var pi = l.substr(ind);
		var fl = l.replace(pi, '/Dashboard/MySpace/List1');
		l = fl;
	}else if( l.indexOf("/Dashboard/ShareInfo") != -1){
		var ind = l.indexOf("/Dashboard/ShareInfo");
		var pi = l.substr(ind);
		var fl = l.replace(pi, '/Dashboard/MySpace/List1');
		l = fl;
	}
	
	$('#shareuser-setting-nav ul li').each( function(){
		$(this).find("a").removeClass("selected");
	});
	$('#shareuser-setting-nav a[href^="' + l + '"]').addClass('selected').parent().addClass('li-selected');
	
    var bodyheight = parseInt($(window).height()) - 100 +'px';
    $("#left-box").height(bodyheight);
	
	
    $(window).resize(function() {
        var bodyheight = $(this).height() - 110;
        $("#left-box").height(bodyheight);
    }).resize();
	
	
	function selectLeftNav(obj){

		$('.with-has-data').each(function(){
				$(".pal_nav li a").removeClass("active");
				$(this).css('font-weight', '');
		}); 
		$(obj).addClass("active");
		$(obj).css('font-weight', 'bold');
		
	}
	$('.with-has-data').click(function(e){
		selectLeftNav(this);
		var section = $(this).attr('href');
		var ypos = $(section).offset().top;
		ypos = ypos - 210;

		 $('body').animate({
				scrollTop: ypos
		 }, 500);
		 e.preventDefault();
	});
	
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();
		var wH = $(window).height();
		
		if ($('.with-has-data').length)
		{
			$('.with-has-data').each(function(){
				var sec_id = $(this).attr('href');
				if ($(sec_id).length)
				{
					var hT = $(sec_id).offset().top,
					hH = $(sec_id).outerHeight();
					if (scroll > (hT+hH-wH)){
						selectLeftNav(this);
					}
				}
			  
			});
		}
		
		if (scroll >= 1) {
			$("#samewidthby").addClass("scroll");
			$(".right_side .header-fixed").addClass("scroll");
			 $("#left-box").addClass("scroll");
		} else {
			$("#samewidthby").removeClass("scroll");
			$(".right_side .header-fixed").removeClass("scroll");
			$("#left-box").removeClass("scroll");
		}
	});
	
	jQuery('body').on('change', '#filter_prefecture', function(){
		$('#filter_district').val('');
		$('.form_filter_district').remove();
		$('#form_filter #prefecture').val($('#filter_prefecture').val());
		$('#form_filter #district').val($('#filter_district').val());
		$('#form_filter #per_page').val($('#per_page').val());
		
		$('#form_filter').submit();
	});

	jQuery('body').on('change', '#quantity-selector-select', function(){
		var quantity = jQuery(this).val();
		$('#form_filter #per_page').val(quantity);
		$('#form_filter #prefecture').val($('#filter_prefecture').val());
		$('#form_filter #district').val($('#filter_district').val());

		$('#form_filter').submit();
	});

	jQuery('body').on('click', '#apply_districts', function(){
		var districts = $('#filter_district').val();
		var district  = '';
        if( null !=  districts){
            jQuery('.form_filter_district').remove();
            for(i=0; i <= districts.length; i++){
    			if(districts[i] != undefined){
    				district = districts[i].trim();
    				jQuery('#form_filter').append('<input type="hidden" class="form_filter_district" name="district['+i+']" value="'+district+'">')
    			}

    		}
            $('#form_filter').submit();

        }else{
            if(jQuery('body').has('.form_filter_district').length){
                jQuery('.form_filter_district').remove();
                $('#form_filter').submit();
                return false;
            }else{
                alert('Choose some district before applying.')
            }
        }


	});
	
	if ($(".custom-checkbox").length)
		$(".custom-checkbox").labelauty();
	
	// Show top notifications
	function showTopNotification()
	{
		var myScroller = $('.header-notification-update div.slimScrollDiv');
		var myToolTip = myScroller.find('ul');
		var offset = 0;
		var heightToLoad = 150;
		
		//Reset offset
		myToolTip.attr('id', 0);
		// Call ajax to load new message
		var loadMoreNotif = function(isScroll){
			// Get offset by id
			var offset = myToolTip.attr('id');
			offset = offset ? offset : 0;
			$.ajax({
	            type: "GET",
	            url: '/GetUserNotifications',
	            data: {offset: offset},
	            dataType: 'json',
	            success: function(response){
            		if(typeof response.offset_count == 'number' && response.offset_count > 0)
            		{
            			if (typeof response.count_total == 'number' && !isScroll) {
        					$('.header-notification-update #notification_count').show();
        					$('.header-notification-update #notification_count').text(response.count_total);
        				}
        				
        				if (response.space.html) {
        					myToolTip.append(response.space.html);
        				}
        					
            			// Display to the tooltip box
            			myToolTip.attr('id', response.offset);
            			
            			myScroller.perfectScrollbar('destroy');
            			// Pefect scrollbar
            			myScroller.perfectScrollbar({
            				  minScrollbarLength: 10,
            				  suppressScrollX: true,
            				  wheelSpeed: 20,
            				  wheelPropagation : false,
            				  scrolled: function(scrollTop, scrollHeight){
            					  var settings = $(this);
            					  if (settings[0].stop == false && (( scrollTop + scrollHeight ) >= ( myToolTip.height() - heightToLoad )))
            					  {
            	      				  // call ajax
            					  	settings[0].stop = true;
            					  	if (response.offset_count)
            					  		loadMoreNotif.call(this, true);
            					  }
            				  }
            			});
            			myScroller.perfectScrollbar('update');
            		}
	            	else
	            	{
	            		if (!isScroll)
	            			$('.header-notification-update #notification_count').hide();
	            		
	            		var liItem = '<li class="item-nomore '+(offset == 0 ? 'first' : '')+'">';
	            		liItem += '<p class="description no-item"> まだお知らせはありません </p>';
	            		liItem += '</li>';
	            		myToolTip.append(liItem);
	            		// empty
	            	}
	            }
			});
		};
		
		// Call function get notifications
		loadMoreNotif.call();
	}
	
	$('body').on('click', '#user-notifications-popover-content .notification-popover-item', function(){
		var liEl = $(this).closest('li');
		$.ajax({
			url : '/GetUserNotifications',
			method: 'get',
			data: {Time: liEl.data('time'), action: 'read'},
			dataType: 'json',
			success : function(resp){
				liEl.fadeOut(function(){
					liEl.remove();
				});
				var notification_count = $('#notification_count').text();
				notification_count = notification_count ? parseInt(notification_count) : 0;
				$('#notification_count').hide();
				$('#notification_count').fadeIn(function(){
					if (notification_count > 1)
						$('#notification_count').text(notification_count - 1);
					else
					{
						$('#notification_count').text('');
						$('#notification_count').hide();
					}
				});
			}
		});
	});
	
	
	if ($('#rentuser_list a.offer_btn').length || $('.offer-lists a.offer_btn').length)
	{
		// Click offer button show popup
    	$('body').on('click', 'a.offer_btn', function (e) {
        	e.preventDefault();
        	var userId = $(this).closest('li').data('id');
        	$('#userReceiveId').val(userId);
    		$('#popover_offer_wrapper').modal({ 
        		show: true,
        		backdrop: 'static',
        		keyboard: false
        	})
        	
       	})
       	
       	$('#popover_offer_wrapper').on('hidden.bs.modal', function (e) {
       		$('#popover_offer_wrapper #offer_list_content').html('');
       	});
       	
    	$('#popover_offer_wrapper').on('show.bs.modal', function (e) {
    		$('.upload_portfolio_success').hide();
    		$('#popover_offer_wrapper').find('.modal-dialog').css({width:'900px', 'max-width': '100%',
                height:'auto', 
               'max-height':'100%'});
			$('#popover_offer_wrapper').find('.modal-body').css({'overflow':'auto', 'max-height': '600px'});
			
    		jQuery.ajax({
    			url : SITE_URL + 'RentUser/GetSpaceOffers',
    			data : {userSendId: $('#userSendId').val(), userReceiveId: $('#userReceiveId').val()},
    			success : function(resp){
    				$('#popover_offer_wrapper #offer_list_content').html(resp);
    			}
    		});
       	}); 

    	$('.offer_list_form').on('submit', function (e) {
        	e.preventDefault();
    		$.ajax({
    			url : SITE_URL + 'RentUser/SaveSpaceOffers',
    			method: 'post',
    			dataType: 'json',
    			data : $('.offer_list_form').serialize(),
    			success : function(resp){
        			if (resp.success) {
    					$('.upload_portfolio_success').text(resp.message);
        				$('.upload_portfolio_success').fadeIn('slow', function(){
        					setTimeout(function(){
        						$('#popover_offer_wrapper').modal('hide');
        					}, 500)
        				});

        				$('#rentuser_list .ns_result[data-id="'+ $('#userReceiveId').val() +'"]').find('a.offer_btn .offer-btn-text').text('オファー済み');
        			}
    			}
    		});
       	}); 
	}
	
	function setupFavoritePopover() {
		var favorited = $('.button-favorite');
		if (favorited.hasClass('favorited'))
		{
			favorited.popover('destroy');
			options = {
				html : true,
				placement: 'bottom',
				template : '<div class="popover favorite-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
				content: '<a href="javascript:void(0);">'+ favorited.data('tooltip') +'</a>',
				trigger: 'click'
			};
			favorited.popover(options);
		}
		return favorited;
	}
	
	if ($('.button-favorite').length) {
		setupFavoritePopover();
		$('body').on('click', '.button-favorite:not(.favorite), .favorite-popover', function(e){
			e.preventDefault();
			var element = $('.button-favorite');
			
			if (!element.hasClass('favorited') || $(this).hasClass('favorite-popover'))
			{
				var hashID = element.data('spaceid');
				var url = SITE_URL + 'RentUser/AddFavoriteSpace/' + hashID;
				$.ajax({
	    			url : url,
	    			method: 'get',
	    			data: {action: (element.hasClass('favorited') ? 'remove' : 'add')},
	    			dataType: 'json',
	    			success : function(response){
	        			if (response.success) {
	        				
	        				var favorited = $('.button-favorite.favorited');
	        				var isFavorite = element.hasClass('favorited');
	        				
	        				if (isFavorite)
	        				{
		    					favorited.popover('destroy');
        						element.toggleClass('favorited');
        						element.find('.favorite-text').text(element.data('favorite'));
	        				}
	        				else
	        				{
        						element.toggleClass('favorited');
    	        				setupFavoritePopover();
        						element.find('.favorite-text').text(element.data('favorited'));
	        				}
	        				
	        				// Change favorite counting 
	        				$('.fav-counter span').fadeOut(function(){
	        					$(this).text(response.count);
	        					$('.fav-counter span').fadeIn();
	        				});
	        			}else {
	        			}
	    			},
	    		});
			}
		});
		
		$('.button-favorite').hover(function(){
			var element = $(this);
			if (element.hasClass('favorited'))
			{
				element.click();
			}
		}, function(){
		});
	}
	
	function setupShareButtonPopover() {
		var sharebtn = $('.share-btn a.btn');
		var socials = $('.social_buttons_wraper .social_buttons');
		sharebtn.popover('destroy');
		options = {
			html : true,
			placement: 'bottom',
			template : '<div class="popover share-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
			content: socials,
			trigger: 'click'
		};
		sharebtn.popover(options);
		return sharebtn;
	}
	$('.share-btn a.btn').on('hide.bs.popover', function (e) {
		var socialClone = $('.share-popover .social_buttons');
		$('.social_buttons_wraper').html(socialClone);
	});
	
	if ($('.share-btn').length) {
		var socialInterval = setInterval(function(){
			if ($('.addthis_content').html()) {
				setupShareButtonPopover();
				clearInterval(socialInterval);
				socialInterval = null;
			}
		}, 300)

		$('body').on('click', '.share-popover', function(e){
			var sharebtn = $('.share-btn a.btn');
			sharebtn.popover('hide');
		});
		
		$('.share-btn a.btn').hover(function(){
			var element = $(this);
			element.click();
		}, function(){
		});
	}
	
	if ($('#reviews_tabs_wraper').length)
	{
		$('#reviews_tabs_wraper').responsiveTabs({
	        rotate: false,
	        startCollapsed: 'accordion',
	        collapsible: 'accordion',
	        //setHash: true,
	        //disabled: [3,4],
	        activate: function(e, tab) {
	        	$('#reviews_tabs_wraper').css('opacity', 1);
	        }
		});
	}
	
	if ($('#spacetabs_wraper').length)
	{
		$('#spacetabs_wraper').responsiveTabs({
	        rotate: false,
	        startCollapsed: 'accordion',
	        collapsible: 'accordion',
	        //setHash: true,
	        //disabled: [3,4],
	        activate: function(e, tab) {
	        	$('#spacetabs_wraper').css('opacity', 1);
	        }
		});
	}
	
	if ($('#login_expired_content_wrapper').length) {
		if (!jQuery.validator)
		{
			var script = document.createElement('script')
			script.src = SITE_URL + 'js/jquery.validate.js';
			document.documentElement.firstChild.appendChild(script)
			
			var checkValidateLoaded = setInterval(function(){
				if (jQuery.validator)
				{
					$("#login_expired_content_wrapper form").validate();
					clearInterval(checkValidateLoaded);
					checkValidateLoaded = null;
				}
			}, 100);
		}
		else 
		{
			$("#login_expired_content_wrapper form").validate();
		}
		
		$("body").on('submit', '#login_expired_content_wrapper form', function(e){
			allowSubmit = false;
			$.ajax({
				url : '/checkSessionExpire?expired=1',
				method: 'get',
				data: $('#login_expired_content_wrapper form').serialize(),
				async: false,
				dataType: 'json',
				success : function(response){
					if (response.token)
					{
						$('#login_expired_content_wrapper #expire_token').val(response.token);
						allowSubmit = true;
						
					}
				}
			});
			if (allowSubmit)
				return true;
			else
				return  false;
		})
		
		// Check session expired
		function checkSessionExpire()
		{
			$.ajax({
				url : '/checkSessionExpire',
				method: 'get',
				data: $('#login_expired_content_wrapper form').serialize(),
				dataType: 'json',
				success : function(response){
					if (response.expired)
					{
						$('#login_expired_content_wrapper').modal({ 
							show: true,
			        		backdrop: 'static',
			        		keyboard: false
		            	})
					}
				}
			});
		}
		
		var expireInterval = setInterval(function(){
			if ($('#login_expired_content_wrapper').is(':hidden'))
			{
				checkSessionExpire();
			}
		}, 60000);
	}
	
	if ($('#login_form_content_wrapper').length) {
		if (!jQuery.validator)
		{
			var script = document.createElement('script')
			script.src = SITE_URL + 'js/jquery.validate.js';
			document.documentElement.firstChild.appendChild(script)
			
			var checkValidateLoaded = setInterval(function(){
				if (jQuery.validator)
				{
					$("#login_form_content_wrapper form").validate();
					clearInterval(checkValidateLoaded);
					checkValidateLoaded = null;
				}
			}, 100);
		}
		else 
		{
			$("#login_form_content_wrapper form").validate();
		}
		
		$("body").on('submit', '#login_form_content_wrapper form', function(e){
			e.preventDefault();
			allowSubmit = false;
			$('body').LoadingOverlay("show");
			$.ajax({
				url : '/checkSessionExpire?expired=1',
				method: 'get',
				data: $('#login_form_content_wrapper form').serialize(),
				dataType: 'json',
				success : function(response){
					if (response.token)
					{
						$('#login_form_content_wrapper #expire_token').val(response.token);
						
						$.ajax({
							url : $('#login_form_content_wrapper form').attr('action'),
							method: 'post',
							data: $('#login_form_content_wrapper form').serialize(),
							async: false,
							dataType: 'json',
							success : function(response){
								$('body').LoadingOverlay("hide");
								if (response.errMessage)
								{
									alert(response.errMessage)
								}
								else {
									location.href = response.redirect;
								}
							},
							error: function(){
								$('body').LoadingOverlay("hide");
							}
						});
						
					}
				}
			});
			return  false;
		})
	}
	
	$( "body" ).on('click', '.nvOpn', function() {
	  $( this ).toggleClass("actv");
	  $( "nav" ).toggle("fast");
	});
	
	
	$('#common_dialog_wraper').on('show.bs.modal', function () {
		$('body').LoadingOverlay("show");
	});
	
	if($('.lnk-reject').length)
	{
		$('body').on('click', '.lnk-reject', function(){
			var myForm = $(this).closest('form');
			
			$.ajax({
				url: '/getBookingPaymentInfo',
				data: myForm.serialize(),
				dataType: 'json',
				method: 'get',
				success: function(response){
					$('#common_dialog_wraper').modal('show');
					$('#common_dialog_wraper .modal-title').html(response.title);
					$('#common_dialog_wraper .modal-body').html(response.body);
					$('#common_dialog_wraper .btn-success').html('続ける');
					$('#common_dialog_wraper .btn-danger').html('閉じる');
					$('#common_dialog_wraper .btn-success').unbind('click').bind('click', function(){
						myForm.submit();
					});
					
					$('body').LoadingOverlay("hide");
					
				},
				error: function(response){
					$('body').LoadingOverlay("hide");
					if (confirm("本当にこの予約をキャンセルしますか?")) {
						myForm.submit();
					} else {
						return false;
					}
					
				}
			});
		});
		
	}
	
	if ($('.lnk-accept-payment').length)
	{
		$('body').on('click', '.lnk-accept-payment', function(){
			var myForm = $(this).closest('form');
			if(confirm('本当にこの予約を受けつけますか?')){
				myForm.submit();
			}
		});
	}
	
	function setHeight() {
		windowHeight = $(window).innerHeight();
		$('.right_side').css('min-height', windowHeight);
		
		var wndow_wd = $( window ).width();
		var wndow_ht = $( window ).height();	
		if(wndow_wd<650) {
			$('nav').css("min-height",wndow_ht);
		}
		else {
			$('nav').css("min-height", 'auto');
		}
	};
	
	function makeSrollDiv() {
		var myScroller = $('div.slimScrollDiv');
		myScroller.perfectScrollbar('destroy');
		// Pefect scrollbar
		myScroller.perfectScrollbar({
			  minScrollbarLength: 10,
			  suppressScrollX: true,
			  wheelSpeed: 20,
			  wheelPropagation : false,
			  scrolled: function(scrollTop, scrollHeight){
			  }
		});
		myScroller.perfectScrollbar('update');
	}
	
	function runInitialize() {
		makeSrollDiv();
		showTopNotification();		
		setHeight();
	}
	
	runInitialize();
	
	$(window).click(function(e) {
		if ($('.popover.in').length && !$(e.target).hasClass('btn'))
		{
			var sharebtn = $('.share-btn a.btn');
			sharebtn.popover('hide');
		}
		
		if ($('.popover.in').length && !$(e.target).hasClass('favorited'))
		{
			var favorited = $('.button-favorite');
			favorited.popover('hide');
		}
		
	});
	
    $(window).resize(function() {
	    setHeight();
    });
	
})

function cloneObject(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}