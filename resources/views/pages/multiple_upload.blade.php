<!-- upload JS, CSS files-->
<script type="text/javascript">
	var SITE_URL = "{{ url('/') }}/";
	var upload_url = '<?php echo $hosting_upload_url?>';
</script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo url('/')?>/js/jfileUpload/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo url('/')?>/js/jfileUpload/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo url('/')?>/js/jfileUpload/css/jquery.fileupload-ui.css">
<link rel="stylesheet" href="<?php echo url('/')?>/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo url('/')?>/css/style.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->


<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="/" method="POST" enctype="multipart/form-data">
	 {{ csrf_field() }}

	<div class="row" id="upload_content">
		<div class="col-md-4 uploader_content">
			<div class="cert-uploader-frame fileupload-buttonbar">
				
				<label class="image-uploder fileinput-button">
					<input type="file" multiple class="form-control" placeholder="" accept=".jpg,.jpeg,.png,.pdf" data-maxfilesize="5MB" data-error-filesize="ファイルが大きすぎます" data-error-filetype="JPEG、PNG、PDFのファイルを選択してください" id="myCertificateDoc" name="files[]">
					<span class="lable-text">
						<p>登記簿謄本</p>
						<i class="fa fa-plus-square" aria-hidden="true"></i>
					</span>
					<img class="thumbnail" src="" style="display: none;">
					<img class="sample" src="/images/sample-cert.jpg">
				</label>
			</div>
		</div>
		<!--/col-xs-6-->
		<div class="col-md-8 uploaded-list-wraper" role="presentation">
			<ul class="uploaded-list files">
			</ul>
		</div>
		<!--/col-xs-6-->
	</div>
	
	<!-- Redirect browsers with JavaScript disabled to the origin page -->
	<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	<div class="send-cert fileupload-buttonbar">
		<button type="submit" class="btn button start"><span>Send</span></button>
	</div>
	
	<div class="send-cert fileupload-buttonbar" style="display: none" id="resend_button_wrapper">
		<button class="btn button delete" id="resend_button"><span>ReSend</span></button>
		<button style="display:none" type="submit" class="btn button delete" id="resend_button_real"><span>ReSend</span></button>
	</div>

	<div class="uploader-message-wraper" style="display: none;">
		<div class="msg success-msg-cert">Your certification has send.</div>
		<label class="sts-cert">under examination...</label>
	</div>

</form>
<br>
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
	<div class="slides"></div>
	<h3 class="title"></h3>
	<a class="prev">‹</a>
	<a class="next">›</a>
	<a class="close">×</a>
	<a class="play-pause"></a>
	<ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <li class="template-upload fade">
        <div class="col-xs-9">
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </div>
        <div style="display: none;">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </div>
    </li>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <li class="template-download fade">
        <div class="col-xs-9">
            <p class="name">
                {% if (file.url) { %}
                    <i class="fa fa-check-circle" aria-hidden="true"></i><a target="_blank" href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <i class="fa fa-check-circle" aria-hidden="true"></i><span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </div>
        <div class="col-xs-1">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input style="display: none;" type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </div>
    </li>
{% } %}
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo url('/')?>/js/jfileUpload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo url('/')?>/js/jfileUpload/js/main.js"></script>
