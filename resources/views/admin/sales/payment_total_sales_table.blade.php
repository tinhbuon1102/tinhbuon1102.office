<?php 
$rent_data = isset($rent_datas[0]) ? $rent_datas[0] : array();
?>

<ul class="chart-legend">
	<li style="border-color: #b1d4ea" class="highlight_series tips" data-series="6">
		<strong>
			<span class="amount">
				<?php echo priceConvert(isset($rent_data['total_gross_sale']) ? $rent_data['total_gross_sale'] : 0, true)?>
			</span>
		</strong>
		この期間の総売上高
		<!--この期間の総売上高-->
	</li>
	<li style="border-color: #b1d4ea" class="highlight_series " data-series="2" data-tip="">
		総売上高平均額:
		<strong>
			<span class="amount">
				<?php echo priceConvert(isset($rent_data['avarage_gross_sale']) ? $rent_data['avarage_gross_sale'] : 0, true)?>
			</span>
		</strong>
	</li>
	<li style="border-color: #3498db" class="highlight_series tips" data-series="7">
		<strong>
			<span class="amount">
				<?php echo priceConvert(isset($rent_data['total_net_sale']) ? $rent_data['total_net_sale'] : 0, true)?>
			</span>
		</strong>
		この期間内のネット売上
	</li>
	<li style="border-color: #3498db" class="highlight_series " data-series="3" data-tip="">
		ネット売上平均額:
		<strong>
			<span class="amount">
				<?php echo priceConvert(isset($rent_data['avarage_net_sale']) ? $rent_data['avarage_net_sale'] : 0, true)?>
			</span>
		</strong>
	</li>
	<li style="border-color: #dbe1e3" class="highlight_series " data-series="1" data-tip="">
		<strong>
			<?php echo isset($rent_data['placed']) ? $rent_data['placed'] : 0 ?>
		</strong>
		予約数
	</li>
	<li style="border-color: #ecf0f1" class="highlight_series " data-series="0" data-tip="">
		<strong>
			<?php echo isset($rent_data['purchased']) ? $rent_data['purchased'] : 0 ?>
		</strong>
		支払数
	</li>
	<li style="border-color: #e74c3c" class="highlight_series " data-series="8" data-tip="">
		<strong>
			<?php echo isset($rent_data['cancelled']) ? $rent_data['cancelled'] : 0 ?>
		</strong>
		キャンセル予約数
	</li>
</ul>
<ul class="chart-widgets"></ul>
