
@include('pages.header')
<!--/head-->
<body class="mypage shareuser">
	<div class="viewport">
		@include('pages.header_nav_shareuser')
		<div class="main-container">
			<div id="main" class="container fixed-container">
				<div id="left-box">
					@include('user1.dashboard.left_nav')
					<!--/right-content-->
				</div>
				<!--/leftbox-->
                <div class="right_side" id="samewidth">
                <div id="page-wrapper">
                <div class="page-header header-fixed">
<div class="container-fluid">
<div class="row">
<div class="col-xs-6 col-md-6 col-sm-8 clearfix">
<h1 class="pull-left" id="bt-s1"><i class="fa fa-user" aria-hidden="true"></i> My Page</h1>
</div>
</div>
</div>
</div>

<div id="MyPageBoard" class="container-fluid">
<div class="alert-container">
<!--show if minimum space profile is not completed-->
				<div class="dashboard-must-validation">
				<div class="dashboard-warn-text">
                <i class="icon-warning-sign fa awesome"></i>
				<div class="warning-heading">スペースの設定が完了していません。</div>
                <div class="warning-msg">
                <a href="#" class="dashboard-must-text-link underline">スペースの設定</a>
                </div>
				</div>
				</div>
<!--/show if minimum space profile is not completed-->
<!--show if cerdificate is not completed and not approval yet-->
				<div class="dashboard-must-validation">
				<div class="dashboard-warn-text">
                <i class="icon-warning-sign fa awesome"></i>
				<div class="warning-heading">証明書の提出が完了していため、アカウントが有効ではありません。</div>
                <div class="warning-msg">
                <a href="#" class="dashboard-must-text-link underline">証明書の提出</a>
                </div>
				</div>
				</div>
<!--/show if cerdificate is not completed and not approval yet-->
@if(Auth::guard('user1')->user()->IsAdminApproved=="No")
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

<div class="row">
<h1>NOT AUTH</h1>
</div><!--/row-->
</div><!--/container-fluid-->

</div><!--/#page-wrapper-->
                </div>

			</div>
		</div>
		<!--/main-container-->
		<!--footer-->
				
		<!--/footer-->
	</div>
	<!--/viewport-->
	<script>
	jQuery(function() {
    	jQuery( "#tabs" ).tabs();
		var tour = new Tour({
			  steps: [
			  {
				element: "#bt-s1",
				title: "Title of my step 1",
				content: "Content of my step 1"
			  }
			],
		    container: "body",
		    smartPlacement: true,
		
		});

		tour.addStep({
				element: "#bt-s2",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 2",
				content: "Content of my step 2"
		});
		
		tour.addStep({
				element: "#bt-s3",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 3",
				content: "Content of my step 3"
		});
		
		tour.addStep({
				element: "#bt-s4",
				placement: "auto left",
				smartPlacement: true,
				title: "Title of my step 4",
				content: "Content of my step 4"
		});
		
		tour.addStep({
				element: "#bt-s5",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 5",
				content: "Content of my step 5"
		});
		
		tour.addStep({
				element: "#bt-s6",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 5",
				content: "Content of my step 5"
		});
		
		tour.addStep({
				element: "#bt-s7",
				placement: "auto left",
				smartPlacement: true,
				title: "Title of my step 7",
				content: "Content of my step 7"
		});
		
		tour.addStep({
				element: "#bt-ms1",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 1",
				content: "Content of my step 1"
		});

		tour.addStep({
				element: "#bt-ms2",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 2",
				content: "Content of my step 2"
		});
		
		tour.addStep({
				element: "#bt-ms3",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 3",
				content: "Content of my step 3"
		});
		
		tour.addStep({
				element: "#bt-ms4",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 4",
				content: "Content of my step 4"
		});
		
		tour.addStep({
				element: "#bt-ms5",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 5",
				content: "Content of my step 5"
		});
		
		tour.addStep({
				element: "#bt-ms6",
				placement: "auto right",
				smartPlacement: true,
				title: "Title of my step 5",
				content: "Content of my step 5"
		});
		
		// Initialize the tour
		tour.init();
		
		// Start the tour
		tour.start();
		
  	});
    </script>
</body>
</html>
