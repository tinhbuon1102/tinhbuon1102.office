@extends('adminLayout') @section('head')
<title>Payment Details</title>
<link href="{{ URL::asset('js/calendar/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('js/calendar/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/calendar/datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ URL::asset('js/calendar/loadingoverlay.js') }}"></script>
@stop 
@section('PageTitle') <div class="header_title pull-left">#01振込詳細</div> @stop 

@section('AfterTitle')
<div class="pull-left text-right">
	<a href="/MyAdmin/Sales#tab-6">
		<button class="btn btn-default" type="button">
			<i class="fa fa-reply"></i>
			<span class="hidden-sm hidden-xs"> 一覧に戻る</span>
		</button>
	</a>
</div>
@stop

@section('Content')
<?php 
if (isset($rent_datas[0])) { 

$rent_data = $rent_datas[0];
$total_include_tax = $total_tax = $total_charge_fee = 0;
?>
<div class="row invoice-view book-data">
	<div class="info-col">
		<div class="info-col col-xs-6">
			<div class="company-detail clearfix">
				<div class="col-xs-12 col-sm-4 col-1">
					<p class="form-control-static">{{getUserName($rent_data->shareUser)}}</p>
					<p class="form-control-static">{{getUserAddress($rent_data->shareUser)}}</p>
					<p class="form-control-static">TEL: {{$rent_data->shareUser->Tel}}</p>
					<p class="form-control-static">Email: {{$rent_data->shareUser->Email}}</p>
				</div>
				<!--/col-1-->
			</div>
			<!--/bg-gry-->
		</div>
		<div class="info-col col-xs-6 col-right">
			<div class="bill-detail bg-gry clearfix">
				<div class="col-xs-12 col-sm-4 col-1">
					<?php if (isset($rent_data->shareUser->bank) && $rent_data->shareUser->bank->BankName) {?>
					<div class="form-group">
						<label>振込先情報</label>
						<div class="row">
							<div class="col-md-4">銀行名:</div>
							<div class="col-md-8">
								<strong>{{$rent_data->shareUser->bank->BankName}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">支店名<!--Branch location-->:</div>
							<div class="col-md-8">
								<strong>{{$rent_data->shareUser->bank->BranchLocationName}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">種類<!--Account Type-->:</div>
							<div class="col-md-8">
								<strong>{{$rent_data->shareUser->bank->AccountType}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">口座番号<!--Account Number-->:</div>
							<div class="col-md-8">
								<strong>{{$rent_data->shareUser->bank->AccountNumber}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">口座名義<!--Account Name-->:</div>
							<div class="col-md-8">
								<strong>{{$rent_data->shareUser->bank->AccountName}}</strong>
							</div>
						</div>
					</div>
					<?php }?>
				</div>
				<!--/col-1-->
			</div>
			<!--/bg-gry-->
		</div>
		<div class="clearfix"></div>
		<div class="info-col ">
			<div class="bg-gry clearfix">
				<div class="table-responsive">
					<div class="ofsp-order-data-row ofso-transfer-table">
						<table class="table table-transfer dataTable table-striped">
							<thead>
								<tr role="row">
									<th>予約番号</th>
									<th>日付</th>
									<th>タイプ</th>
									<th class="th-spname">スペース名</th>
									<th class="flright">単価</th>
									<th class="flright">期間</th>
									<th class="flright">合計金額</th>
									<th class="flright">合計金額(税込)</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($rent_datas as $rent_data) {
									$groupPrices = array();
									$space = $rent_data->bookedSpace;
									$rent_data->isArchive = true;
									$aFlexiblePrice = getFlexiblePrice($rent_data, new \App\Bookedspaceslot());
									if (isset($aFlexiblePrice['prices']) && count($aFlexiblePrice['prices']))
									{
										foreach ($aFlexiblePrice['prices'] as $subPrice)
										{
											$groupPrices[$subPrice['SpecialDay']][] = $subPrice;
										}
									}
									$total_include_tax += $rent_data->amount - $rent_data->ChargeFee;
									$total_tax += $rent_data->Tax;
									$total_charge_fee += $rent_data->ChargeFee;
								?>
								<!--loop-->
								<tr>
									<td class="pdl18"><a target="_blank" href="/MyAdmin/ShareUser/Dashboard/EditBook/{{$rent_data->id}}">#{{$rent_data->id}}</a></td>
									<td class="pdl18">{{renderJapaneseDate($rent_data->charge_start_date)}}</td>
									<td class="pdl18">{{getSpaceTypeText($rent_data->bookedSpace)}}</td>
									<td class="pdl18"><a target="_blank" href="/MyAdmin/ShareUser/{{$rent_data->shareUser->HashCode}}/EditSpace/{{$rent_data->bookedSpace->HashID}}">{{getSpaceTitle($rent_data->bookedSpace, 50)}}</a></td>
									<td class="flright">
										<?php
										foreach ($groupPrices as $groupPrice)
										{
										?>
										<?php if ($groupPrice[0]['SpecialDay']) {?>
										<p class="unit-price"> <?php echo $groupPrice[0]['SpecialDay']?>: <?php echo priceConvert($groupPrice[0]['price'], true);?></p>
										<?php } else {?>
										<span class="unit-price"><?php echo priceConvert(flexibleSpacePrice($space), true)?></span>
										<?php }?>
										<?php
										}
										?>
									</td>
									<td class="flright">{{$rent_data->DurationText}}</td>
									<td class="flright">{{priceConvert($rent_data->SubTotal, true)}}</td>
									<td class="flright">{{priceConvert($rent_data->SubTotal + $rent_data->Tax, true)}}</td>
								</tr>
								<!--/loop-->
								<?php }?>
							</tbody>
						</table>
					</div>
					<!--/ofso-book-edit-table-->
					<div class="ofsp-order-data-row ofso-book-total-table">
						<table class="table table-totalbook dataTable">
							<tbody>
								<tr>
									<td class="label-td">合計金額(税込):</td>
									<td class="total total_sales_amount">{{priceConvert($total_include_tax, true)}}<br/><small>(内、消費税{{priceConvert($total_tax, true)}})</small></td>
								</tr>
								
								<tr>
									<td class="label-td">手数料 (10%):</td>
									<td class="total tax">-{{priceConvert($total_charge_fee, true)}}</td>
								</tr>
								<tr class="transfer-amount">
									<td class="label-td">合計支払金額:</td>
									<td class="total_pay_amount">{{priceConvert($total_include_tax - $total_charge_fee, true)}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--/ofso-book-total-table-->
				</div>
			</div>
			<!--/bg-gry-->
		</div>
		<!--/info-col-->
	</div>
</div>
<!--/row-->
<?php }
else {
?>	
	<div class="no-data"><?php echo 'No data'?></div>
<?php
}?>
@stop
