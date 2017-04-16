
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php');
 ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="booking-process common">
<div class="viewport">
		@if(Auth::check()) @include('pages.header_nav_shareuser') @elseif(Auth::guard('user2')->check()) @include('pages.header_nav_rentuser') @endif
		<section id="page">
			<div id="main">
				<header class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-sm-7">
								<h1 itemprop="name">予約詳細</h1>
							</div>
							<!--/col-sm-7-->
							<div class="col-sm-5 hidden-xs">
								<div itemprop="breadcrumb" class="breadcrumb clearfix">
									<a href="#" title="hOur Office">Home</a>
									<a href="#" title="Booking">予約</a>
									<span>予約詳細</span>
								</div>
							</div>
							<!--/col-sm-5-->
						</div>
						<!--/row-->
					</div>
					<!--/container-->
				</header>
				<div id="content" class="pt30 pb30">
					<!--details booking-->
					<div id="confirm-book" class="container">
						<div class="row mb30" id="booking-breadcrumb">
							<div class="col-xs-4">
								<a href="#">
									<div class="breadcrumb-item active">
										<i class="fa fa-info-circle"></i>
										<span>延長申込</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-4">
								<a href="#">
									<div class="breadcrumb-item">
										<i class="fa fa-credit-card"></i>
										<span>支払い</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
							<div class="col-xs-4">
								<a href="#">
									<div class="breadcrumb-item">
										<i class="fa fa-check-circle"></i>
										<span>申込完了</span>
									</div>
								</a>
							</div>
							<!--/col-xs-3-->
						</div>
						<form id="ExtendPayment" method="post">
															
							<div class="row mb30">
								<div class="col-md-6">
									<table class="book-details book-table billing-table">
										<tbody>
											<tr class="t-caption">
												<th colspan="2">延長時間</th>
											</tr>
											<tr class="pad">
												<th>時間</th>
												<td>
													<select class="pop-one-sel">
														<option value="1">1時間</option>
														<option value="2">2時間</option>
														<option value="3">3時間</option>
														<option value="4">4時間</option>
														<option value="5">5時間</option>
														<option value="6">6時間</option>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-md-6">
									<div id="booking-summary-block">
										<table class="book-details book-table no-border-table" id="booking_summary">
										<tbody>
										<tr class="t-caption">
										<th colspan="2">予約詳細</th>
										</tr>
										<tr class="ver-top pad">
										<th>
										<h3>{Space Name}</h3>
										<p>利用タイプ:<strong> 時間毎 </strong><br/>予約番号:<strong> {booking ID} </strong></p>
										</th>
										<td>
										<span class="pull-right lead text-center price-value subtotal_value">¥{price per an hour} / 時</span>
										</td>
										</tr>
										</tbody>
										</table>
										<table class="book-details book-table calc-table no-border-table">
										<tbody>
										<tr class="total-amount-value ver-top pad-top20 no-btm-pad">
										<th><h3>合計金額</h3></th>
										<td>
										<div class="lead text-right"><span id="total_booking">¥{total price}</span></div>
										</td>
										</tr>
										<tr class="no-pad summary-price">
										<th style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
										<p class="total-calc">
										<span class="unit-price ajax_hour_day">{price per an hour}</span>x<span class="qty weekday_qty">{extend hours}</span>時間
										</p>
										</th>
										<td style="padding: 16px 16px 0; font-size: 15px; text-align: left; vertical-align: top; color: #888;">
										<div class="lead text-right">
										<span id="unit_total" class="price-value select-subtot  weekday" style="float: right">
										<small>¥{subtotal}</small>
										</span>
										</div>
										</td>
										</tr>
										<tr class="no-pad">
										<th><p class="total-calc"><span class="subtotal">小計</span></p></th>
										<td>
										<div class="lead text-right">
										<span id="unit_total" class="price-value subtotal_value1" style="float: right"><small>¥{subtotal}</small></span>
										</div>
										</td>
										</tr>
										<tr class="no-pad">
										<th><p class="other-fee">消費税</p></th>
										<td><div class="lead text-right"><span id="tax_fee"><small>¥{subtotal tax}</small></span></div></td>
										</tr>
										<tr class="no-pad">
										<th><p class="other-fee">手数料(10%)</p></th>
										<td><div class="lead text-right"><span id="margin_fee"><small>¥{margin fee}</small></span></div></td>
										</tr>
										</tbody>
										</table>
									</div>
									<div class="confirm-term">
										<p>
											<a href="{{url('/')}}/TermCondition/RentUser" target="_blank">利用者規約</a>
											を確認した上で、予約を進めてください。
										</p>
										<input type="checkbox" id="checkTerm" />
										<span>
											<a href="{{url('/')}}/TermCondition/RentUser" target="_blank">利用者規約</a>
											に同意する
										</span>
									</div>
								</div>
							</div>
							<!--.mb30-->
							<div class="step-btn-group">
								<a class="btn btn-default btn-lg pull-left" href="{{getSpaceUrl($rent_data->spaceID->HashID)}}">
									<i class="fa fa-angle-left"></i>
									戻る
								</a>
								<button type="submit" name="book" class="btn btn-primary btn-lg pull-right" id='next_step'>
									次へ
									<i class="fa fa-angle-right"></i>
								</button>
							</div>
						</form>
					</div>
					<!--/container-->
					<!--/details booking-->
				</div>
				<!--footer-->
				@include('pages.dashboard_user1_footer')
				<!--/footer-->
			</div>
			<!--/#main-->
		</section>
	</div>
</body>
</html>
