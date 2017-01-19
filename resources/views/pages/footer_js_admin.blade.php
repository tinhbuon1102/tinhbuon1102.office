<link type="text/css" href="{{ URL::asset('js/cropimage/css/jquery.Jcrop.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ URL::asset('js/cropimage/js/jquery.form.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/cropimage/js/jquery.Jcrop.js') }}"></script>
<script src="{{ URL::asset('js/jquery.autoKana.js') }}"></script>

<?php 

	$imageUploadUrl1 = Request::url() . '/UploadImage';

?>
<div class="modal1 fade" id="preview_content_wrapper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" ></h4>
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>



<div class="modal1 fade" id="popover_content_wrapperAdmin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myLargeModalLabel">Upload Photos</h4>
			</div>
			<div class="modal-body">
				<div class="crop_set_preview">
					<div class="crop_preview_left">
						<div class="crop_preview_box_big" id='viewimage'></div>

						<form name="thumbnail1" action="<?php echo $imageUploadUrl1?>" method="post">
							{{ csrf_field() }} 
							<input type="hidden" name="x1" value="" id="x1" />
							<input type="hidden" name="y1" value="" id="y1" />
							<input type="hidden" name="x2" value="" id="x2" />
							<input type="hidden" name="y2" value="" id="y2" />
							<input type="hidden" name="w" value="" id="w" />
							<input type="hidden" name="h" value="" id="h" />
							<input type="hidden" name="wr" value="" id="wr" />
							<input type="hidden" name="filename" value="" id="filename" />
							<input type="hidden" name="image-type" value="" id="image-type" />
							<div class="crop_preview_submit">
								<input type="submit" name="upload_thumbnail" value="メイン画像として設定" id="save_thumb1" class="btn btn-success submit_button" />
							</div>
							<input type="hidden" name="backurl" value="{{Request::url()}}" />
							<input type="hidden" name="upload_thumbnail" value="Set as Profile Picture"  />
						</form>

						<form class="uploadform" method="post" enctype="multipart/form-data" action='{{url('/')}}/upload-image.php' name="photo">
							{{ csrf_field() }} 
							<div class="crop_set_upload">
								<input type="hidden" value="Upload" class="upload_button" name="submitbtn" />
								<button type="button" id="btn-image-save" class="btn btn-image-save">
									<span>写真を変更</span>
								</button>
								<input type="hidden" name="image-id" class="image-id" value=""/>
								<input type="file" name="imagefile" id="imagefile" class="hide_broswe" style="display: none;" />
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
