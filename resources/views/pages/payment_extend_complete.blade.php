
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
        <h1 class="big" itemprop="name">延長申込完了</h1>
        </div><!--/col-sm-7-->
        
        
        </div><!--/row-->
        </div><!--/container-->
        </header>
				<div id="content" class="pt30 pb30">
					<!--details booking-->
					<div id="confirm-book" class="container">
					<div class="text-center lead pt20 pb20">
					<h1>延長予約の申し込みが完了しました</h1>
					<p class="comp-msg">延長内容の確認メールが登録されたメールアドレス宛に送信されますので、ご確認ください。</p>
					</div>
					<div class="row mb30 pt30">
					<div class="col-md-4">
					<table class="book-summary book-table billing-table">
					<tbody>
					<tr class="t-caption"><th colspan="2">支払い方法</th></tr>
					<tr><td colspan="2">{Payment Method}</td></tr>
					<tr class="t-caption"><th colspan="2">請求先情報</th></tr>
					<tr><td colspan="2">{LastName} {FirstName}</td></tr>
					<tr><td colspan="2">{PostalCode} {full address}</td></tr>
					<tr><th>電話番号</th><td>{tel}</td></tr>
					<tr><th>メールアドレス</th><td>{Email}</td></tr>
					</tbody>
					</table>
					</div>
					<div class="col-md-8">
					<table class="book-details book-table no-border-table">
					<tbody>
					<tr class="t-caption"><th colspan="2">延長予約詳細</th></tr>
					<tr class="ver-top pad">
					<td><img src="http://coreworking.xsrv.jp//images/space/25/main_5887054a009da_25.jpg" class="space-thum" /></td>
					<td><h3><a href='#'>{Space Name}</a></h3>
					<div class="detail-list row">
					<div class="col-md-4">予約番号:</div>
					<div class="col-md-8"><strong>{booking ID}</strong></div>
					</div>
					<div class="detail-list row">
					<div class="col-md-4">延長時間:</div>
					<div class="col-md-8">
					<strong>{extend hours}時間</strong>
					</div>
					</div>
					<div class="detail-list row">
					<div class="col-md-4">利用タイプ:</div>
					<div class="col-md-8"><strong>時間毎</strong></div>
					</div>
					</td>
					</tr>
					</tbody>
					</table>
					
					<table class="book-details book-table calc-table no-border-table">
					<tbody>
					<tr class="total-amount-value ver-top pad-top20 no-btm-pad"><th>
					<h3>合計金額</h3>
					</th>
					<td><div class="lead text-right"><span id="total_booking">¥{total price}</span></div></td>
					</tr>
					<tr class="no-pad">
					<th><p class="total-calc"><span class="subtotal">小計</span></p></th>
					<td>
					<div class="lead text-right">
					<span id="unit_total" class="price-value" style="float: right"><small>¥{subtotal}</small></span>
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
					</div><!--.mb30-->
					<div class="clearfix"></div>
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
