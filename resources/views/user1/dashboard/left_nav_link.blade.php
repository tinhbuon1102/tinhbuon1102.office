<?php
$user = isset($user) ? $user : Auth::guard('user1')->user();
$loggedUser = Auth::guard('user2')->check() ? Auth::guard('user2')->user() : Auth::guard('user1')->user();
// Get Booking status
$allDatas = \App\Rentbookingsave::select('rentbookingsaves.*')
->where('rentbookingsaves.InvoiceID', '<>', '')
->where('rentbookingsaves.User1ID', $user->id)
->joinSpace()
->groupBy(array('rentbookingsaves.id'))
->where('rentbookingsaves.status', BOOKING_STATUS_PENDING);
	
$totalCountStatus = $allDatas->get()->count();
?>
<li class="pc-none side-panel-item">
	<div class="side-panel-btn side-panel-btn-active">
		<a id="bt-ms0" href="{{url('ShareUser/Dashboard')}}" class="content-navigation">
			<img src="{{getUser1Photo($loggedUser)}}" class="img-icon media-circle" />
			ダッシュボード
		</a>
		<div class="user-controls">
			<a class="text-link" title="Logout" href="/User1/Logout">
				<i class="fa fa-power-off" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</li>
<?php if (IsAdminApprovedUser($user)) {?>
<li class="pc-none side-panel-item">
	<a id="bt-ms01" href="{{url('ShareUser/Dashboard/Message')}}" class="content-navigation">
		<span class="nav-link-notification-wrap">
			<?php $unread = readCountNoti(Auth::guard('user1')->user()->HashCode,'User1ID');?>
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
<li class="pc-none side-panel-item">
	<a id="bt-ms01" href="{{url('ShareUser/Dashboard/MyPage')}}" class="content-navigation">
		<i class="fa fa-user" aria-hidden="true"></i>
		マイページ
		<!--MyPage-->
	</a>
</li>
<li class="side-panel-item">
	<a id="bt-ms1" href="{{url('ShareUser/Dashboard/MySpace/List1')}}" class="content-navigation">
		<i class="fa fa-building" aria-hidden="true"></i>
		{{ trans('navigation.space') }}
		<!--スペース-->
		<!--Space-->
	</a>
</li>
<li class="side-panel-item">
	<a id="bt-ms2" href="{{url('ShareUser/Dashboard/BookList')}}" class="content-navigation">
		<span class="nav-link-notification-wrap">
			<?php if ($totalCountStatus) {?>
			<span class="nav-link-notification"><?php echo $totalCountStatus?></span>
			<?php }?>
			<i class="fa fa-list-alt" aria-hidden="true"></i>
		</span>
		<span class="next-noticon">
			{{ trans('navigation.reservation') }}
			<!--予約-->
		</span>
		<!--Reservation List-->
	</a>
</li>
<?php if (count($user->spaces)) {?>
<li class="side-panel-item">
	<a id="bt-ms3" href="{{url('ShareUser/Dashboard/MySpace/Calendar')}}" class="content-navigation">
		<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
		{{ trans('navigation.calendar') }}
		<!--カレンダー-->
		<!--Calendar-->
	</a>
</li>
<?php }?>
<li class="side-panel-item">
	<a id="bt-ms4" href="{{url('ShareUser/Dashboard/InvoiceList')}}" class="content-navigation">
		<i class="fa fa-credit-card" aria-hidden="true"></i>
		{{ trans('navigation.recipt') }}
		<!--支払通知書-->
		<!--Invoice-->
	</a>
</li>
<?php if (IsAdminApprovedUser($user)) {?>
<li class="side-panel-item">
	<a id="bt-ms5" href="{{url('ShareUser/Dashboard/OfferList')}}" class="content-navigation">
		<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
		{{ trans('navigation.offer_list') }}
		<!--オファーリスト-->
		<!--Offer list-->
	</a>
</li>
<?php }?>
<li class="side-panel-item">
	<a id="bt-ms6" href="{{url('ShareUser/Dashboard/DesiredPerson')}}" class="content-navigation">
		<i class="fa fa-heart" aria-hidden="true"></i>
		{{ trans('navigation.desired_person') }}
		<!--出会いたい人材-->
		<!--Desired Person Setting-->
	</a>
</li>
<li class="pc-none side-panel-item">
	<a id="bt-ms6" href="{{url('ShareUser/Dashboard/Review')}}" class="content-navigation">
		<i class="fa fa-pencil-square-o" aria-hidden="true"></i>レビュー
	</a>
</li>
<?php if (IsAdminApprovedUser($user)) {?>
<li class="pc-none side-panel-item">
	<a id="bt-ms7" href="{{url('RentUser/list')}}" class="content-navigation">
		<i class="fa fa-search" aria-hidden="true"></i>
		利用者を探す
	</a>
</li>
<?php }?>
<li class="side-panel-item pushy-submenu">
	<a id="bt-ms8" href="{{url('ShareUser/Dashboard/HostSetting')}}" class="content-navigation">
		<i class="fa fa-cogs" aria-hidden="true"></i>
		{{ trans('navigation.setting') }}
		<!--設定-->
		<!--Setting-->
	</a>
	<ul data-bind="visible: workspaceCurrent" class="pal_nav">
                                            
                                        <?php if (!IsAdminApprovedUser($user)) {?>
                                        <li>
			<a href="#certificate" class="fa with-has-data hasData" style="font-weight: bold;">
				{{ trans('navigation.certificate') }}
				<!--証明書-->
			</a>
		</li>
                                        <?php }?>
                                        <li>
			<a href="#profile" class="fa with-has-data">
				{{ trans('navigation.company_info') }}
				<!--会社情報-->
			</a>
		</li>
		<li>
			<a href="#rperson" class="fa with-has-data">
				{{ trans('navigation.person_in_charge_info') }}
				<!--担当者情報-->
			</a>
		</li>
		<li>
			<a href="#set-logo" class="fa with-has-data">
				{{ trans('navigation.logo_setting') }}
				<!--ロゴ設定-->
			</a>
		</li>
		<li>
			<a href="#payinfo" class="fa with-has-data">
				{{ trans('navigation.transfer_info') }}
				<!--振込先情報-->
			</a>
		</li>
		<li>
			<a href="#host-member" class="fa with-has-data">
				{{ trans('navigation.host_member') }}
				<!--管理メンバー-->
			</a>
		</li>
	</ul>
</li>