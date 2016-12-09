<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ URL::asset('admin/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

	<!-- DataTables CSS -->
    <link href="{{ URL::asset('admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{ URL::asset('admin/dist/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('admin/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ URL::asset('admin/bower_components/morrisjs/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ URL::asset('admin/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<? 
if (!defined('SITE_URL')) define('SITE_URL', url('/') . '/');
 ?>
 <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
 <link rel="stylesheet" href="{{ URL::asset('css/responsive.css') }}">
 <link href="<?php echo SITE_URL?>admin/css/myadmin.css" rel="stylesheet">
 
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>css/typeahead.tagging.css">
<!-- slider JS files -->
<link rel="stylesheet" type='text/css' href="<?php echo SITE_URL?>js/labeluty/jquery-labelauty.css">
 
	<script type="text/javascript">
	var SITE_URL = '<?php echo SITE_URL?>';
	
	var SPACE_FIELD_CORE_WORKING = '{{SPACE_FIELD_CORE_WORKING}}';
	var SPACE_FIELD_OPEN_DESK = '{{SPACE_FIELD_OPEN_DESK}}';
	var SPACE_FIELD_SHARE_DESK = '{{SPACE_FIELD_SHARE_DESK}}';
	var SPACE_FIELD_PRIVATE_OFFICE = '{{SPACE_FIELD_PRIVATE_OFFICE}}';
	var SPACE_FIELD_PRIVATE_OFFICE_OLD = '{{SPACE_FIELD_PRIVATE_OFFICE_OLD}}';
	var SPACE_FIELD_TEAM_OFFICE = '{{SPACE_FIELD_TEAM_OFFICE}}';
	var SPACE_FIELD_OFFICE = '{{SPACE_FIELD_OFFICE}}';
	var SPACE_FIELD_METTING = '{{SPACE_FIELD_METTING}}';
	var SPACE_FIELD_SEMINAR_SPACE = '{{SPACE_FIELD_SEMINAR_SPACE}}';
			
</script>
</script>
    <script src="{{ URL::asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

	<script src="<?php echo SITE_URL?>js/jquery.responsiveTabs.js"></script>
 <!-- <script src="<?php echo SITE_URL?>admin/js/admin.js"></script> -->
<script>window.symphony = window.symphony || {}; window.symphony['extension_version'] = '0.7';</script>


    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('admin/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

   
   <!-- DataTables JavaScript -->
    <script src="{{ URL::asset('admin/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('admin/dist/js/sb-admin-2.js') }}"></script>
	
	
	
<script src="http://www.office-spot.com/js/jquery.webui-popover.js" ></script>

<script class="rs-file" src="http://www.office-spot.com/js/assets/royalslider/jquery.royalslider.min.js"></script>
<link class="rs-file" href="http://www.office-spot.com/js/assets/royalslider/royalslider.css" rel="stylesheet">
<script class="rs-file" src="http://www.office-spot.com/js/assets/royalslider/jquery.easing-1.3.js"></script>
<script src="http://www.office-spot.com/js/labeluty/jquery-labelauty.js"></script>
<!-- syntax highlighter -->
<script src="http://www.office-spot.com/js/assets/preview-assets/js/highlight.pack.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script> hljs.initHighlightingOnLoad();</script>
<!-- preview-related stylesheets -->
<link href="http://www.office-spot.com/js/assets/preview-assets/css/reset.css" rel="stylesheet">
<link href="http://www.office-spot.com/js/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css" rel="stylesheet">
<link href="http://www.office-spot.com/js/assets/preview-assets/css/github.css" rel="stylesheet">

<script src="http://www.office-spot.com/js/perfect-scrollbar/js/jquery.mousewheel.min.js" type="text/javascript"></script>
<script src="http://www.office-spot.com/js/perfect-scrollbar/js/perfect-scrollbar.js" type="text/javascript"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
	@yield('head')
	<script type="text/javascript">
	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
		"formatted-num-pre" : function(a) {
			a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
			return parseFloat(a);
		},

		"formatted-num-asc" : function(a, b) {
			console.log(a + '--' + b);
			return a - b;
		},

		"formatted-num-desc" : function(a, b) {
			return b - a;
		}
	});
	</script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Core Work Admin Panel</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{ Auth::guard('useradmin')->user()->UserName   }}  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('MyAdmin/Logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       
                        <li>
                            <a href="{{ url('MyAdmin/Dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                      <!--  <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                        </li>-->
						 <li>
                            <a href="{{ url('MyAdmin/User1') }}"><i class="fa fa-user" aria-hidden="true"></i> シェア会員(貸す側)</a>
                        </li>
						 <li>
                            <a href="{{ url('MyAdmin/User2') }}"><i class="fa fa-user" aria-hidden="true"></i> レント会員(借りる側)</a>
                        </li>
                        <li>
                            <a href="{{ url('MyAdmin/Spaces') }}"><i class="fa fa-building" aria-hidden="true"></i></i> スペース一覧</a>
                        </li>
                        <li>
                            <a href="{{ url('MyAdmin/Sales') }}"><i class="fa fa-university" aria-hidden="true"></i> 売上</a>
                        </li>
                        <!--<li>
						<a href="#">
							<i class="fa fa-dashboard fa-fw"></i>
							Payment Invoice
						</a>
					</li>-->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" class="page-wrapper-admin">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('PageTitle') @yield('AfterTitle')</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
           
			@yield('Content')
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->

	@yield('Footer')
	
	<div class="modal fade" id="common_dialog_wraper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="vertical-alignment-helper">
			<div id="common_dialog_content" class="modal-dialog modal-md vertical-align-center ">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<div class="pull-right">
							<button type="button" class="btn btn-success">
								Save
							</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								Close
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
</body>

</html>
