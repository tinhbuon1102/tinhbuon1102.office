/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

function calculateHeightUloadIframe(){
	iframe = $(window.parent.document.getElementById('iframe_upload'));
	iframe.height(iframe.contents().find('#fileupload').outerHeight() + 50);
	iframe.css('opacity', 1);
}

function showHideUploader(action, pageload)
{
	if(action == 1)
	{
		//Show
		$('.uploader-message-wraper').hide();
		$('#resend_button_wrapper').hide();
    	$('#upload_content .uploader_content').fadeIn();
    	$('#upload_content .uploaded-list-wraper').removeClass('col-md-12');
    	$('.fileupload-buttonbar .start').show();
	}
	else
	{
		//Hide
		if (!pageload)
			$('.uploader-message-wraper').fadeIn();
		
    	$('#resend_button_wrapper').fadeIn();
    	$('#upload_content .uploader_content').hide();
    	$('#upload_content .uploaded-list-wraper').addClass('col-md-12');
    	$('.fileupload-buttonbar .start').hide();
	}

}

jQuery(function($){
    $('iframe#iframe_upload').on('load', function(){
    	calculateHeightUloadIframe();
    });
    
    $('body').on('click', '#resend_button', function(){
    	if (!confirm('This action will remove all old documents and make resend again, Are you sure ?'))
    		return;
    	
    	$('input[type="checkbox"][name="delete"]').prop('checked', true);
    	setTimeout(function(){
    		$('#resend_button_real').trigger('click');
    		showHideUploader(1);
    	}, 100)
    });
});

jQuery(function ($) {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: upload_url
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        SITE_URL + 'js/jfileUpload/js/cors/result.html?%s'
    );

    $('#fileupload') .bind('fileuploadadd', function (e, data) {
    	$('.uploader-message-wraper').fadeOut();
    	setTimeout(function(){
    		calculateHeightUloadIframe();
    	},300)
    })
    
    $('#fileupload') .bind('fileuploadsend', function (e, data) {
    	showHideUploader(0);
    	setTimeout(function(){
    		calculateHeightUloadIframe();
    	},400)
    })
    
    // Load existing files:
    $('#fileupload').addClass('fileupload-processing');
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), {result: result});
        	if (result.files.length)
        	{
        		showHideUploader(0, 1);
        	}
        	else {
        		showHideUploader(1, 1);
        	}
        
        	setTimeout(function(){
        		calculateHeightUloadIframe();
        	},400);
        	
    });

});
