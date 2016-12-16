<?php 
include (dirname(dirname(__FILE__)) . '/config.php');
?>
<?php include( ROOT_PATH_FOLDER . '/admin/header.php'); ?>
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
					<i class="fa fa-user fa-fw"></i>
					admin
					<i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li>
						<a href="#">
							<i class="fa fa-user fa-fw"></i>
							User Profile
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-gear fa-fw"></i>
							Settings
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="{{url('/')}}/MyAdmin/Logout">
							<i class="fa fa-sign-out fa-fw"></i>
							Logout
						</a>
					</li>
				</ul>
				<!-- /.dropdown-user -->
			</li>
			<!-- /.dropdown -->
		</ul>
		<!-- /.navbar-top-links -->

		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav in" id="side-menu">

					<li>
						<a href="{{url('/')}}/MyAdmin/Dashboard">
							<i class="fa fa-dashboard fa-fw"></i>
							Dashboard
						</a>
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
						<a href="{{url('/')}}/MyAdmin/User1">
							<i class="fa fa-dashboard fa-fw"></i>
							シェア会員(貸す側)
						</a>
					</li>
					<li>
						<a href="{{url('/')}}/MyAdmin/User2">
							<i class="fa fa-dashboard fa-fw"></i>
							レント会員(借りる側)
						</a>
					</li>
                    <li>
						<a href="#" class="active">
							<i class="fa fa-dashboard fa-fw"></i>
							Payment Invoice
						</a>
					</li>

				</ul>
			</div>
			<!-- /.sidebar-collapse -->
		</div>
		<!-- /.navbar-static-side -->
	</nav>

	<div id="page-wrapper" style="min-height: 687px;">
		<div class="row">
			<div class="col-lg-12">
				<div class="page-header">
					<h1 class="page-header">請求書番号#01の詳細</h1>
					
				</div>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->


<div class="row invoice-view book-data">
<div class="info-col">
<div class="info-col col-xs-12 col-sm-4 col-right">
<div class="bg-gry clearfix">
   <h3>予約概要</h3>
   <div class="col-xs-12 col-sm-4 col-1">
	<div class="form-group">
         <label>顧客名(Customer Name)</label>
         <p class="form-control-static">Kyoko Furuya</p>
    </div>
   </div><!--/col-1-->
   <div class="col-xs-12 col-sm-4 col-1">
	<div class="form-group">
         <label>予約日時(Book Date)</label>
         <p class="form-control-static">2016-09-20&nbsp;18:28</p>
    </div>
   </div><!--/col-1-->
   <div class="col-xs-12 col-sm-4 col-1">
	<div class="form-group">
         <label>予約状況(Status)</label>
         <p class="form-control-static">Completed</p>
    </div>
   </div><!--/col-1-->
   <div class="col-xs-12 col-sm-4 col-1">
	<div class="form-group">
         <label>利用日(Usage Date)</label>
         <p class="form-control-static">2016-09-25</p>
    </div>
   </div><!--/col-1-->
   
   </div><!--/bg-gry-->
   </div>
<div class="info-col col-xs-12 col-sm-4 col-2">
<div class="bg-gry clearfix">
<h3>スペース利用額</h3>
<div class="table-responsive">
<div class="ofsp-order-data-row ofso-book-edit-table">
<table class="table table-editbook dataTable">
<thead>
<tr role="row">
<th class="th-spname">Space Name</th>
<th class="flright">Price</th>
<th class="flright">Duration</th>
<th class="flright">Subtotal</th>
</tr>
</thead>
<tbody>
<tr>
<td>WeeklySpace</td>
<td class="flright">12,000</td>
<td class="flright">2  Days</td>
<td class="flright">24,000</td>
</tr>
</tbody>
</table>
</div><!--/ofso-book-edit-table-->
<div class="ofsp-order-data-row ofso-book-total-table">
<table class="table table-totalbook dataTable">
<tbody>
<tr><td class="label-td">tax:</td><td class="total tax">¥1,920</td></tr>
<tr><td class="label-td">charge:</td><td class="total tax">¥2,400</td></tr>
<tr><td class="label-td">Total Amount:</td><td class="total total_amount">¥28,320</td></tr>
</tbody>
</table>
</div><!--/ofso-book-total-table-->
</div>
</div><!--/bg-gry-->
</div><!--/col-2-->
<div class="info-col col-xs-12 col-sm-4 col-2 bill-details">
<div class="bg-gry clearfix">
<div class="space-summary col-xs-8 col-sm-6">
<h4>決済詳細</h4>
<div class="pay-method">
<p>
<strong>支払い方法(Payment Method)</strong><br/>
Paypal</p>
<p>
<strong>Transaction ID</strong><br/>
ch_fl57y24KEaeWazi</p>
<p>
<strong>Payment Date</strong><br/>
2016-09-24 19:50:25</p>
</div>
</div><!--/space-summary-->
<div class="bill-summary col-xs-8 col-sm-6">
<h4>支払明細</h4>
<div class="address">
<p>
<strong>請求先</strong><br/>
Full Name<br/>
Full Name Kana<br/>
〒196-0012<br/>東京昭島市3-2-3-1006</p>
<p>
<strong>Eメール</strong><br/>
kyoko@heart-hunger.com</p>
<p>
<strong>電話番号</strong><br/>
09052159711</p>
</div>
</div><!--/bill-summary-->
</div><!--/bg-gry-->
</div><!--/col-2-->
</div>
</div><!--/row-->
		
	</div>
	<!-- /#page-wrapper -->

</div>
</body>
</html>
