<?php 
$user = isset($user) ? $user : Auth::guard('user1')->user();
?>
<!--<li>
											<a href="http://office-spot.com/ShareUser/Dashboard/MyPage" class="content-navigation selected">
												<i class="fa fa-user" aria-hidden="true"></i>
												My Page
												<!--マイページ-->
											<!--</a>
										</li>-->
                                        <li class="pc-none side-panel-item">
                                        <div class="side-panel-btn side-panel-btn-active">
                                        <a id="bt-ms0" href="{{url('ShareUser/Dashboard')}}" class="content-navigation">
                                        <img src="{{getUser1Photo($user)}}" class="img-icon media-circle" />
                                        ダッシュボード
                                        </a>
                                        <div class="user-controls">
                                            <a class="text-link" title="Logout" href="/User1/Logout">
                                            <i class="fa fa-power-off" aria-hidden="true"></i>
                                            </a>
                                            </div>
                                        </div>
                                        </li>
                                        <li class="pc-none">
											<a id="bt-ms01" href="{{url('ShareUser/Dashboard/MyPage')}}" class="content-navigation">
												<i class="fa fa-user" aria-hidden="true"></i>
												マイページ
												<!--MyPage-->
											</a>
                                            
										</li>
										<li>
											<a id="bt-ms1" href="{{url('ShareUser/Dashboard/MySpace/List1')}}" class="content-navigation">
												<i class="fa fa-building" aria-hidden="true"></i>
												{{ trans('navigation.space') }}<!--スペース-->
												<!--Space-->
											</a>
                                            
										</li>
                                        <li>
											<a id="bt-ms2" href="{{url('ShareUser/Dashboard/BookList')}}" class="content-navigation">
												<i class="fa fa-list-alt" aria-hidden="true"></i>
												{{ trans('navigation.reservation') }}<!--予約-->
												<!--Reservation List-->
											</a>
										</li>
										<?php if (count($user->spaces)) {?>
										<li>
											<a id="bt-ms3" href="{{url('ShareUser/Dashboard/MySpace/Calendar')}}" class="content-navigation">
												<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
												{{ trans('navigation.calendar') }}<!--カレンダー-->
												<!--Calendar-->
											</a>
										</li>
										<?php }?>
                                        <li>
											<a id="bt-ms4" href="{{url('ShareUser/Dashboard/InvoiceList')}}" class="content-navigation">
                                            <i class="fa fa-credit-card" aria-hidden="true"></i>
												{{ trans('navigation.recipt') }}<!--支払通知書-->
												<!--Invoice-->
                                                
											</a>
										</li>
										<li>
											<a id="bt-ms5" href="{{url('ShareUser/Dashboard/OfferList')}}" class="content-navigation">
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
												{{ trans('navigation.offer_list') }}<!--オファーリスト-->
												<!--Offer list-->
                                                
											</a>
										</li>
                                        <li>
											<a id="bt-ms6" href="{{url('ShareUser/Dashboard/DesiredPerson')}}" class="content-navigation">
                                            <i class="fa fa-heart" aria-hidden="true"></i>
												{{ trans('navigation.desired_person') }}<!--出会いたい人材-->
												<!--Desired Person Setting-->
                                                
											</a>
										</li>
                                        <li class="pc-none">
											<a id="bt-ms6" href="{{url('RentUser/list')}}" class="content-navigation">
                                            <i class="fa fa-search" aria-hidden="true"></i>
												利用者を探す
                                                
											</a>
										</li>
										<li>
											<a id="bt-ms7" href="{{url('ShareUser/Dashboard/HostSetting')}}" class="content-navigation">
												<i class="fa fa-cogs" aria-hidden="true"></i>
												{{ trans('navigation.setting') }}<!--設定-->
												<!--Setting-->
											</a>
                                            <ul data-bind="visible: workspaceCurrent" class="pal_nav">
                                            
                                        <?php if (!IsAdminApprovedUser($user)) {?>
                                        <li><a href="#certificate" class="fa with-has-data hasData" style="font-weight:bold;">{{ trans('navigation.certificate') }}<!--証明書--></a></li>
                                        <?php }?>
                                        <li><a href="#profile" class="fa with-has-data">{{ trans('navigation.company_info') }}<!--会社情報--></a></li>
                                        <li><a href="#rperson" class="fa with-has-data">{{ trans('navigation.person_in_charge_info') }}<!--担当者情報--></a></li>
                                        <li><a href="#set-logo" class="fa with-has-data">{{ trans('navigation.logo_setting') }}<!--ロゴ設定--></a></li>
                                        <li><a href="#payinfo" class="fa with-has-data">{{ trans('navigation.transfer_info') }}<!--振込先情報--></a></li>
                                        <li><a href="#host-member" class="fa with-has-data">{{ trans('navigation.host_member') }}<!--管理メンバー--></a></li>
                                        </ul>
										</li>