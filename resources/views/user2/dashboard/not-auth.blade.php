
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header.php'); ?>
 @include('pages.header')
<!--/head-->
<body class="mypage">
<div class="viewport">
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_rentuser.php'); ?>
 @include('pages.header_nav_rentuser')
<div class="main-container">
<div id="main" class="container fixed-container">
<div id="left-box" class="col_3_5">
					@include('user2.dashboard.left_nav')
						
				</div>
				<!--/leftbox-->
<div id="samewidth" class="right_side">
<div id="page-wrapper">
<div class="page-header header-fixed">
<div class="container-fluid">
<div class="row">
<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
<h1 class="pull-left" id="bt-s1"><i class="fa fa-user" aria-hidden="true"></i> My Page</h1>
</div>
</div>
</div>
</div><!--/page-header header-fixed-->
<div id="MyPageBoard" class="container-fluid">
<div class="alert-container">
<!--show if minimum space profile is not completed-->
				<div class="dashboard-must-validation">
				<div class="dashboard-warn-text">
                <i class="icon-warning-sign fa awesome"></i>
				<div class="warning-heading">プロフィールの設定が完了していません。</div>
                <div class="warning-msg">
                <a href="{{url('RentUser/Dashboard/MyProfile')}}" class="dashboard-must-text-link underline" target="_blank">プロフィール編集</a>
                </div>
				</div>
				</div>
<!--/show if minimum space profile is not completed-->
<!--show if cerdificate is not completed-->
				<div class="dashboard-must-validation">
				<div class="dashboard-warn-text">
                <i class="icon-warning-sign fa awesome"></i>
				<div class="warning-heading">証明書の提出が完了していため、アカウントが有効ではありません。</div>
                <div class="warning-msg">
                <a href="#" class="dashboard-must-text-link underline">証明書の提出</a>
                </div>
				</div>
				</div>
<!--/show if cerdificate is not completed-->
@if(Auth::guard('user2')->user()->IsAdminApproved=="No")
<!--show if user is not approval yet-->
				<div class="dashboard-must-validation">
				<div class="dashboard-warn-text">
                <i class="icon-warning-sign fa awesome"></i>
				<div class="warning-heading">審査中の為、アカウント権限が制限されています。</div>
                
				</div>
				</div>
<!--/show if user is not approval yet-->
@endif
</div><!--/alert-container-->

<div class="notify auth-limit">
<h1>アカウント制限</h1>
<p>あなたのアカウント権限が制限されているため、このページを利用できません。</p>
</div><!--/row-->

</div><!--/MyPageBoard-->
</div><!--/page-wrapper-->
</div><!--/right_side-->
</div>
</div><!--/main-container-->

</div><!--/viewport-->

</body>
</html>
