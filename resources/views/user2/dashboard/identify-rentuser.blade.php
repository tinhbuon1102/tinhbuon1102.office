<?php 
//define('SITE_URL', 'http://office-spot.com/design/')
?>

<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')
<!--/head-->
<style>

.error 
	{
	color:red;
	}
</style>
<link rel="stylesheet" href="http://office-spot.com/design/js/chosen/chosen.min.css">
<body class="mypage">
	<div class="viewport">
		<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
				 @include('pages.header_nav_rentuser')

		<div class="main-container">
			<div id="main" class="container fixed-container">
            
			
				<div id="left-box" class="col_3_5">
					@include('user2.dashboard.left_nav')
				</div>
				<!--/leftbox-->
				<div id="samewidth" class="right_side">
                <div id="page-wrapper" class="nofix">
                <div class="page-header header-fixed">
<div class="container-fluid">
<div class="row">
<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
<h1 class="pull-left"><i class="fa fa-cogs" aria-hidden="true"></i> 本人確認手続き</h1>
</div>

</div>
</div>
</div><!--/page-header header-fixed-->
					<div id="feed">
						<section class="feed-event recent-follow feed-box">
							
							<div class="space-setting-content">
									<div class="form-container">
									<?php $error = Session::get('error'); ?>
			<?php $message = Session::get('success'); ?>
        @if( isset($error) )
        <div class="alert alert-danger">{!! $error !!}</div>
        @endif
		
		 @if( isset($message) )
        <div class="alert alert-success">{!! $message !!}</div>
        @endif
<form id="basicinfo" action="" method="post" enctype="multipart/form-data">
{{ csrf_field() }} 
<div class="user-setting">

<fieldset>
<div class="identity-explain">
<p>アカウントを有効にするには、本人確認書類の提出が必要です。<br/>
お客様の本人手続きが完了するまで、スペースの予約、プロフィールページの公開ができません。</p>
<p>以下の手順に従って、本人確認手続きを行って下さい。お手続きが完了するまで1~2日間程度かかる場合がありますので、予めご了承ください。また、お送り頂いた書類に不備があった場合は、3~4日間程度かかることがありますので、ご注意ください。</p>
<p>本人確認手続きを提出される前に以下をご確認ください。</p>
<ul>
<li><a href="{{url('help/rentuser/certificate')}}" target="_blank">提出に必要な書類を確認する</a></li>
<li>アカウントに登録された情報を確認。変更がある場合には登録する。</li>
<li>提出された本人確認書類の情報が正確であること、アカウントに登録されている氏名、生年月日、住所が本人確認書類と一致していることを確認する。</li>
</ul>
<p>以下のファイルアップローダーから、必要書類をアップロードし本人確認手続きをおこなってください。</p>
</div>
<div class="hr"></div>
<div class="form-field">
<div class="input-container2">
<label>ファイル</label><input name="userfile[]" required type="file" multiple /></div>
<div class="input-container2">
<label>種類</label>
<select name="doctype" required>
  <option value="">選択してください</option>
  <option value="運転免許証">運転免許証</option>
  <option value="パスポート">パスポート</option>
  <option value="住民基本台帳カード">住民基本台帳カード</option>
  <option value="健康保険証">健康保険証</option>
  <option value="各種年金手帳">各種年金手帳</option>
  <option value="各種福祉手帳">各種福祉手帳</option>
  <option value="補完書類">補完書類</option>
</select>
</div>
<div class="input-container2">
<label>備考</label>
<textarea rows="4" cols="50" name="Description">
</textarea>
</div>
<div class="input-container2 pdl20"><input type="submit" value="アップロード"  class="btn ocean-btn" /></div>
<div class="table-responsive">
<table class="table table-wht table-bordered dataTable no-footer">
<thead>
<tr><th>書類の種類</th><th>ファイル名</th><th class="fl-note">備考</th><th class="dl-fl">アクション</th></tr>
</thead>
<tbody>
@if($userIde->count()>0)
@foreach($userIde as $i)
	<tr>
		<td >{{$i->FileType}}</td>
		<td >{{$i->FilePath}}</td>
		<td >{{$i->Description}}</td>
		<td ><a href='/RentUser/Dashboard/Identify/Upload/Delete/{{$i->HashID}}' class="btn remove_btn"><i class="fa fa-minus-circle" aria-hidden="true"></i>削除</a></td>
</tr>
@endforeach
@else
<tr>
<td colspan="4"><p class="doc_no_yet">まだ提出された書類はありません</p></td>
</tr>
@endif

<!--<tr>
<td></td><td></td><td></td><td></td>
</tr>-->
</tbody>
</table>

<?php if ($user->IsAdminApproved == 'Yes') {?>
<!--<div class="certificate-approve">
	Certificated are approved
</div>-->
	
<?php }else {?>
<!--<div class="certificate-note-approve">
	Certificated are not approved
</div>-->
<?php }?>
<div class="btn-groups"><a href='/RentUser/Dashboard/Identify/Upload/Send'><button class="button btn ocean-btn" type='button'><i class="fa fa-file-text" aria-hidden="true"></i>書類を提出</button></a><button class="button btn">キャンセル</button></div>
</div>
</div>

</fieldset>
<div class="hr"></div>

</div>
</form>
</div>
								
								<!--/form-container-->
							</div>
							<!--/space-setting-content-->
						</section>

					</div>
					<!--/feed-->
</div><!--/page-wrapper-->
					

				</div>
				<!--/right_side-->
                
			</div>
		</div>
		<!--/main-container-->
		
	</div>
	<!--/viewport-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->

  <script src="<?php echo SITE_URL?>js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo SITE_URL?>js/chosen/chosen.proto.min.js" type="text/javascript"></script>
  <script src="<?php echo SITE_URL?>js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>

<script src="{{ URL::asset('js/jquery.validate.js?v=1') }}"></script>
<script src="{{ URL::asset('js/KanaMaker.js') }}"></script>
	<script src="{{ URL::asset('js/kana.js') }}"></script>
		<script>
		jQuery("#basicinfo").validate({
				  	errorPlacement: function(label, element) { 
						label.addClass('form-error');
						label.insertAfter(element);
			},
			rules: {
			    
			  }
			});
			
			
			 
		</script>
	
		<script>
$ = jQuery.noConflict();
$(document).ready(function() {
	$('body').on('click', '#SubmitBtn', function(){
		$('form#basicinfo').submit();
	});
	
});
</script>	
</body>
</html>
