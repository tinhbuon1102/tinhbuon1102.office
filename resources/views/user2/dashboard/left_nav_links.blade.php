<?php
$user = isset($user) ? $user : Auth::guard('user2')->user();
$loggedUser = Auth::guard('user2')->check() ? Auth::guard('user2')->user() : Auth::guard('user1')->user();
?>
<li class="pc-none side-panel-item">
	<div class="side-panel-btn side-panel-btn-active">
		<a id="bt-ms0" href="{{url('RentUser/Dashboard')}}" class="content-navigation">
			<img src="{{getUser2Photo($loggedUser)}}" class="img-icon media-circle" />
			ダッシュボード
		</a>
		<div class="user-controls">
			<a class="text-link" title="Logout" href="/User2/Logout">
				<i class="fa fa-power-off" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</li>
<?php if (IsAdminApprovedUser($user)) {?>
<li class="pc-none side-panel-item">
	<a id="bt-ms01" href="{{url('RentUser/Dashboard/Message')}}" class="content-navigation">
		<span class="nav-link-notification-wrap">
			<?php $unread = readCountNoti(Auth::guard('user2')->user()->HashCode,'User2ID');?>
			<?php if ($unread) {?>
			<span class="nav-link-notification">{{$unread}}</span>
			<?php }?>
			<i class="fa fa-commenting" aria-hidden="true"></i>
		</span>
		<span class="next-noticon">メッセージ</span>
		<!--MyPage-->
	</a>
</li>
<?php }?>
<li class="side-panel-item">
	<a id="bt-ms1" href="{{url('RentUser/Dashboard/MyPage')}}" class="content-navigation">
		<i class="fa fa-user" aria-hidden="true"></i>
		{{ trans('navigation.my_page') }}
		<!--マイページ-->
		<!--My Page-->
	</a>
</li>
<li class="pc-none side-panel-item">
	<a id="bt-ms01" href="{{url('RentUser/Dashboard/SearchSpaces')}}" class="content-navigation">
		<i class="fa fa-search" aria-hidden="true"></i>
		スペースを探す
	</a>
</li>
<li class="side-panel-item">
	<a id="bt-ms2" href="{{url('RentUser/Dashboard/EditMySpace')}}" class="content-navigation">
		<i class="fa fa-building" aria-hidden="true"></i>
		{{ trans('navigation.desired_space') }}
		<!--希望スペース設定-->
		<!--Desired Space-->
	</a>
</li>
<li class="side-panel-item">
	<a id="bt-ms3" href="{{url('RentUser/Dashboard/Reservation')}}" class="content-navigation">
		<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
		{{ trans('navigation.reservation') }}
		<!--予約-->
		<!--Reservation-->
	</a>
</li>
<li class="side-panel-item">
	<a id="bt-ms3" href="{{url('RentUser/Dashboard/Calendar')}}" class="content-navigation">
		<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
		{{ trans('navigation.calendar') }}
		<!--カレンダー-->
		<!--Calendar-->
	</a>
</li>

<li class="side-panel-item">
	<a id="bt-ms3" href="{{url('RentUser/Dashboard/InvoiceList')}}" class="content-navigation">
		<i class="fa fa-credit-card" aria-hidden="true"></i>
		{{ trans('navigation.invoice_list') }}
		<!--請求書-->
		<!--Invoice List-->
	</a>
</li>
<?php if (IsAdminApprovedUser($user)) {?>
<li class="side-panel-item">
	<a id="bt-ms4" href="{{url('RentUser/Dashboard/OfferList')}}" class="content-navigation">
		<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
		{{ trans('navigation.offer_list') }}
		<!--オファーリスト-->
		<!--Offer list-->
	</a>
</li>
<?php }?>
<li class="side-panel-item">
	<a id="bt-ms5" href="{{url('RentUser/Dashboard/Favorite')}}" class="content-navigation">
		<i class="fa fa-star" aria-hidden="true"></i>
		{{ trans('navigation.fav_list') }}
		<!--お気に入り-->
		<!--Favourite list-->
	</a>
</li>
<li class="side-panel-item pc-none">
	<a id="bt-ms5" href="{{url('RentUser/Dashboard/Review')}}" class="content-navigation">
		<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
		レビュー
		<!--レビュー-->
	</a>
</li>
<li class="side-panel-item">
	<a id="bt-ms6" href="{{url('RentUser/Dashboard/BasicInfo/Edit')}}" class="content-navigation">
		<i class="fa fa-cogs" aria-hidden="true"></i>
		{{ trans('navigation.setting') }}
		<!--設定-->
		<!--Setting-->
	</a>
</li>