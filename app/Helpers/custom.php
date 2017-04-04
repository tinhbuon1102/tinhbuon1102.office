<?php
function pr($data)
{
	echo '<pre>'; print_r($data); echo '</pre>';
}

function detectWebUrl($url) {
	$regex = '((https?|ftp)://)?'; // SCHEME
	$regex .= '([a-z0-9+!*(),;?&=$_.-]+(:[a-z0-9+!*(),;?&=$_.-]+)?@)?'; // User and Pass
	$regex .= '([a-z0-9-.]*)\.([a-z]{2,4})'; // Host or IP
	$regex .= '(:[0-9]{2,5})?'; // Port
	$regex .= '(/([a-z0-9+$_%-]\.?)+)*/?'; // Path
	$regex .= '(\?[a-z+&\$_.-][a-z0-9;:@&%=+/$_.-]*)?'; // GET Query
	$regex .= '(#[a-z_.-][a-z0-9+$%_.-]*)?'; // Anchor
	
	if(preg_match("~^$regex$~i", $url, $m))
	{
		return true;
	}
	return false;
}


function msort($array, $key, $sort_flags = SORT_REGULAR) {
	if (is_array($array) && count($array) > 0) {
		if (!empty($key)) {
			$mapping = array();
			foreach ($array as $k => $v) {
				$sort_key = '';
				if (!is_array($key)) {
					$sort_key = $v[$key];
				} else {
					// @TODO This should be fixed, now it will be sorted as string
					foreach ($key as $key_key) {
						$sort_key .= $v[$key_key];
					}
					$sort_flags = SORT_STRING;
				}
				$mapping[$k] = $sort_key;
			}
			asort($mapping, $sort_flags);
			$sorted = array();
			foreach ($mapping as $k => $v) {
				$sorted[] = $array[$k];
			}
			return $sorted;
		}
	}
	return $array;
}



function getNestedParentUrl(){
	$currentUrl = Request::url();
	$aUrl = explode('/', $currentUrl);
	if (!empty($aUrl))
	{
		unset($aUrl[count($aUrl) - 1]);
		return implode('/', $aUrl);
	}
	return $currentUrl;
}

function getH1OfFile($fileName)
{
	if (file_exists($fileName))
	{
		$contents = File::get($fileName);
		$pattern = "/<h1 ?.*>(.*)<\/h1>/";
		preg_match($pattern, $contents, $matches);
		$pageName = @$matches[1];
		$pageName = $pageName ? $pageName : 'Missing H1';
	}
	else {
		$pageName = 'Missing H1';
	}
	
	return $pageName;
}

function redirectToDashBoard() {
	if ((Auth::guard('user1')->check()))
		return redirect('/ShareUser/Dashboard');
	elseif ((Auth::guard('user2')->check()))
	return redirect('/RentUser/Dashboard');
	else
		return redirect('/');
}


function isFavorited($uid,$spaceid)
{
	$fav=\App\Favorite::firstOrNew([
			'User2Id' => $uid,
			'SpaceId' => $spaceid,
			]);
	if (!$fav->exists) {
		return false;
	}
	return true;

}

function getAuth()
{
	if(Auth::check() || Auth::guard('user2')->check())
		return true;
	return false;
}

function createRandomInvoiceID($len = 7){
	$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
	shuffle($seed);
	$rand = '';
	foreach (array_rand($seed, $len) as $k) {
		$rand .= $seed[$k];
	}
	return $rand;
}

function priceConvert($price, $showCurrency = false, $html = false)
{
	$price = ceil(str_replace(',', '', $price));
	$price = @number_format((float)$price, 0);
	$price = ($showCurrency ? '¥' : '') . ($html ? '<strong class="price-label">'. $price .'</strong>' : $price);
	return $price;
}

function is2TimeRangeOverlap($bookedSlot, $postSlot)
{
	if (
			$bookedSlot['StartDate'] == $postSlot['StartDate'] && $bookedSlot['EndDate'] == $postSlot['EndDate'] &&
			($bookedSlot['StartTime'] <= $postSlot['StartTime'] && $bookedSlot['EndTime'] >= $postSlot['EndTime'] ||
			$bookedSlot['StartTime'] <= $postSlot['StartTime'] && $bookedSlot['EndTime'] > $postSlot['StartTime'] ||
			$bookedSlot['StartTime'] < $postSlot['EndTime'] && $bookedSlot['EndTime'] >= $postSlot['EndTime'] ||
			$bookedSlot['StartTime'] >= $postSlot['StartTime'] && $bookedSlot['EndTime'] <= $postSlot['EndTime'])
	) {
		// Over lap
		return true;
	}
	return false;
}

function readCount($cid,$id,$type)
{
	$cnt=\App\Chatmessage::where('ChatID','=', $cid)->where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}
function readCountNoti($id,$type)
{
	$cnt=\App\Chatmessage::where($type,'')->where('IsRead','=','No')->whereIn('ChatID', function($query) use ($id,$type){
		$query->select(array('id'))->from('chats')->where($type,'=',$id)->get();
	})->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function readCountYes($id,$type)
{
	$cnt=\App\Chatmessage::where($type,'')->where('IsRead','=','Yes')->whereIn('ChatID', function($query) use ($id,$type){
		$query->select(array('id'))->from('chats')->where($type,'=',$id)->get();
	})->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function readCountTotal($id,$type)
{
	$cnt=\App\Chatmessage::where($type,'')->whereIn('ChatID', function($query) use ($id,$type){
		$query->select(array('id'))->from('chats')->where($type,'=',$id)->get();
	})->count();
	//$cnt=\App\Chatmessage::where($type,'=', $id)->where('IsRead','=','No')->count();
	return($cnt);
}

function getUser1ChatNotification(\App\Chatmessage $ch)
{
	return('<li class="notification-popover-item">
			<a href="/ShareUser/Dashboard/Message/'.$ch->User2ID.'">
			<figure id="profile-figure" class="profile-img">
			<img src="'.getUser2Photo($ch->User2ID).'">
			</figure>
				
			<div class="notification-item-content">
			<h4 class="notification-item-title">
			'.$ch->user2->LastName.' '.$ch->user2->FirstName.'
			<span class="online-status online" data-size="medium"></span>
			</h4>
			<p class="notification-item-text">'.str_limit(strip_tags($ch->Message), NOTIFICATION_STR_LIMIT).'</p>
			<div class="notification-item-status">
			<time class="timestamp">'.renderHumanTime($ch->created_at).'</time>
			</div>
			</div>
			</a>	</li>');
}

function getUser2ChatNotification(\App\Chatmessage $ch)
{
	return('<li class="notification-popover-item">
			<a href="/RentUser/Dashboard/Message/'.$ch->User1ID.'">
			<figure id="profile-figure" class="profile-img">
			<img src="'.getUser1Photo($ch->User1ID).'">
			</figure>
				
			<div class="notification-item-content">
			<h4 class="notification-item-title">
			'.$ch->user1->LastName.' '.$ch->user1->FirstName.'
			<span class="online-status online" data-size="medium"></span>
			</h4>
			<p class="notification-item-text">'.str_limit(strip_tags($ch->Message), NOTIFICATION_STR_LIMIT).'</p>
			<div class="notification-item-status">
			<time class="timestamp">'.renderHumanTime($ch->created_at).'</time>
			</div>
			</div>
			</a>	</li>');
}

function getUser1Name($user){
	return $user->NameOfCompany ? $user->NameOfCompany : ($user->LastName .' ' . $user->FirstName);
}

function userHasCompany($user)
{
	return isset($user->UserType) && $user->UserType == '法人' && $user->NameOfCompany;
}
function getUser2Name($user){
	if (userHasCompany($user))
	{
		return $user->NameOfCompany ? $user->NameOfCompany : ($user->LastName .' ' . $user->FirstName);
	}
	else {
		return $user->LastName .' ' . $user->FirstName;
	}
	
}

function getUserName($user){
	if (!$user)
	{
		return 'ユーザーはいません';
	}
	
	if (userHasCompany($user) || isset($user->isUser1))
	{
		return $user->NameOfCompany ? $user->NameOfCompany : ($user->LastName .' ' . $user->FirstName);
	}
	else {
		return $user->LastName .' ' . $user->FirstName;
	}

}

function getUserAddress($user)
{
	if ($user)
	{
		$address = $user->Prefecture . (isset($user->District) ? $user->District : $user->City) . $user->Address1;
		$address = $address ? $address : $user->Address;
		return $address;
	}
	return '';
}

function getUser1ProfilePercentMaper(){
	return array(
			'NameOfCompany' => '5',
			'Address1' => '1.25',
			'PostalCode' => '1.25',
			'Prefecture' => '1.25',
			'District' => '1.25',
			'Tel' => '5',
		    'BussinessCategory' => '5',
			'LastName' => '5',
			'FirstName' => '5',
			'LastNameKana' => '5',
			'FirstNameKana' => '5',
			'BusinessTitle' => '2.5',
			'Department' => '2.5',
			'CellPhoneNum' => '2.5',
		    'NumberOfEmployee' => '2.5',
			'Logo' => '10',
			'BusinessKindWelcome' => '5',
		    'DisiredSex' => '5',
		    'DisiredAge' => '5',
			'Skills' => '5',//80
			'Relation' => array(
				'bank' => array(
					'AccountName' => '3',
					'BankName' => '3',
					'BranchLocationName' => '3',
					'BranchCode' => '3',
					'AccountNumber' => '3',//15
				),
				'certificates' => array(
					'Path' => '5',
					'multiple' => true,
				),
			),
	);
}

function getUser2ProfilePercentMaper(){
	return array(
			'UserName' => '5',
			'LastName' => '1.25',
			'FirstName' => '1.25',
			'LastNameKana' => '1.25',
			'FirstNameKana' => '1.25',
			'BirthYear' => '5',
			'Sex' => '5',
			'Tel' => '5',
			'Address1' => '2.5',
			'PostalCode' => '2.5',
			'Prefecture' => '2.5',
			'City' => '2.5',
			'UserType' => '5',
			'BusinessType' => '5',
			'card_number' => '5',
			'BusinessSummary' => '5',
			'Skills' => '5',//60
			
			'Relation' => array(
				'certificates' => array(
					'FilePath' => '5',
					'multiple' => true,
				),
				'portfolio' => array(
					'Photo' => '10',
					'multiple' => true,
				),
				'billings' => array(
					'billingId' => '5',
				),//20
				'space' => array(
					'SpaceType' => '4',
					'DesireLocationPrefecture' => '2',
					'BudgetType' => '2',
					'TimeSlot' => '2',
					'NumberOfPeople' => '2',
					'SpaceArea' => '2',
					'BusinessType' => '2',
					//'notes_ideals' => '2',
					'NumOfDesk' => '2',
					'NumOfChair' => '2',
				),//20
			),
	);
}

function calculateUserProfilePercent($user, $userType = 1)
{
	if ($userType == 1)
		$aMapper = getUser1ProfilePercentMaper();
	else
		$aMapper = getUser2ProfilePercentMaper();
	
	$totalPercent = 0;
	foreach ($aMapper as $field => $percent)
	{
		if ($field == 'Relation')
		{
			$aRelation = $percent;
			foreach ($aRelation as $relationName => $relationMapper)
			{
				foreach ($relationMapper as $relationField => $relationPercent)
				{
					// Check relation is many or one
					if (isset($relationMapper['multiple']))
					{
						if ($relationField != 'multiple')
						{
							$relationData = isset($user->{$relationName}) ? $user->{$relationName} : array();
							$percent = isset($relationData[0]) ? (trim($relationData[0]->{$relationField}) ?  $relationPercent : 0) : 0;
							$totalPercent += $percent;
							if ($percent) break;
						}
					}
					else {
						$totalPercent += isset($user->{$relationName}->{$relationField}) ? (trim($user->{$relationName}->{$relationField}) ?  $relationPercent : 0) : 0;
					}
				}
			}
		}
		else 
		{
			$totalPercent += isset($user->{$field}) ? (trim($user->{$field}) ?  $percent : 0) : 0;
		}
	}
	
	// Manually set payment percent point
	if ($userType != 1)
	{
		if (isset($user->billings) && $user->billings->billingId && !$user->card_number)
		{
			$totalPercent += 5;
		}
		elseif ((!isset($user->billings) || (isset($user->billings) && !$user->billings->billingId)) && $user->card_number)
		{
			$totalPercent += 5;
		}
	}
	
	return $totalPercent;
}

function getUserAage($user)
{
	if (!$user->BirthYear) return '-';
	
	$dateTime = new \Carbon\Carbon;
	$age = $dateTime->createFromDate($user->BirthYear, $user->BirthMonth, $user->BirthDay)->diff($dateTime->now());
	return $age->y;
}

function renderHumanTime($dateTime) {
	\Carbon\Carbon::setLocale('ja');
	return \Carbon\Carbon::createFromTimeStamp(strtotime($dateTime))->diffForHumans();
}

function renderCustomDate($date, $hasYear=true, $hasMonth=true, $hasDay=true, $hasTime=false)
{
	$format = '';
	$format .= $hasYear ? 'Y' : '';
	$format .= $hasMonth ? '-m' : '';
	$format .= $hasDay ? '-d' : '';
	$format .= $hasTime ? ' H:i:s' : '';
	echo date($format, strtotime($date));
}

function getDateFormat($hasTime = true)
{
	$format = 'Y年m月d日';
	$format .= $hasTime ? ' G:i' : '';
	return $format;
}

function getTimeFormat($time)
{
	$format = 'G:i';
	return date($format, strtotime($time));
}

function getDateFromStrTime($strTime)
{
	return date('Y-m-d H:i:s', $strTime);
}

function renderJapaneseDate($date, $hasTime = true)
{
	return date(getDateFormat($hasTime), strtotime($date));
}

function getStartEndTimeFromRange($hourlyRange, $convert = true)
{
	$aHourly = explode('-', $hourlyRange);

	if ($convert)
	{
		$startTime = getTimeFormat($aHourly[0]);
		$endTime = getTimeFormat($aHourly[1]);
		
		return array($startTime, $endTime);
	}
	else {
		$startTime = date('H', strtotime(trim($aHourly[0])));
		$endTime = date('H', strtotime(trim($aHourly[1])));
		return $aHourly;
	}
}

function getDurationTimeRange($hourlyRange)
{
	$aHourly = explode('-', $hourlyRange);
	$startTime = date('H', strtotime(trim($aHourly[0])));
	$endTime = date('H', strtotime(trim($aHourly[1])));
	return abs($endTime - $startTime);
}

function IsAdminApprovedUser($user) {
	return $user->IsAdminApproved == 'Yes';
}

function IsEmailVerified($user) {
	return $user->IsEmailVerified == 'Yes';
}


function getUser1DashboardNotifications(){
	return array(
			NOTIFICATION_FAVORITE_SPACE,
			NOTIFICATION_REVIEW_BOOKING,
			NOTIFICATION_BOOKING_REFUND_NO_CHARGE,
			NOTIFICATION_BOOKING_CHANGE_STATUS,
			NOTIFICATION_BOOKING_REFUND_50,
			NOTIFICATION_BOOKING_REFUND_100,
			NOTIFICATION_BOOKING_PLACED);
}

function getUser1BookingNotifications(){
	return array(
		NOTIFICATION_REVIEW_BOOKING, 
		NOTIFICATION_BOOKING_PLACED);
}

function getUser2DashboardNotifications(){
	return array(
			NOTIFICATION_SPACE,
			NOTIFICATION_REVIEW_BOOKING,
			NOTIFICATION_BOOKING_PLACED,
			NOTIFICATION_BOOKING_REFUND_NO_CHARGE,
			NOTIFICATION_BOOKING_CHANGE_STATUS,
			NOTIFICATION_BOOKING_REFUND_50,
			NOTIFICATION_BOOKING_REFUND_100);
}

function getUser2BookingNotifications(){
	return array(
			NOTIFICATION_REVIEW_BOOKING,
			NOTIFICATION_BOOKING_PLACED,
			NOTIFICATION_BOOKING_CHANGE_STATUS,
			NOTIFICATION_BOOKING_REFUND_NO_CHARGE,
			NOTIFICATION_BOOKING_REFUND_50,
			NOTIFICATION_BOOKING_REFUND_100);
}

function getBusinessTypes(){
	return array(
		'インターネット・ソフトウェア' => 'インターネット・ソフトウェア',
		'コンサルティング・ビジネスサービス' => 'コンサルティング・ビジネスサービス',
		'コンピュータ・テクノロジー' => 'コンピュータ・テクノロジー',
		'メディア/ニュース/出版' => 'メディア/ニュース/出版',
		'園芸・農業' => '園芸・農業',
		'化学' => '化学',
		'教育' => '教育',
		'金融機関' => '金融機関',
		'健康・医療・製薬' => '健康・医療・製薬',
		'健康・美容' => '健康・美容',
		'工学・建設' => '工学・建設',
		'工業' => '工業',
		'小売・消費者商品' => '小売・消費者商品',
		'食品・飲料' => '食品・飲料',
		'政治団体' => '政治団体',
		'地域団体' => '地域団体',
		'電気通信' => '電気通信',
		'険会社' => '険会社',
		'法律' => '法律',
		'輸送・運輸' => '輸送・運輸',
		'旅行・レジャー' => '旅行・レジャー',
		'デザイン' => 'デザイン',
		'写真' => '写真',
		'映像' => '映像',
		'その他' => 'その他',
		'特に無し' => '特に無し',
	);
}

function getUserBusinessTypes(){
	return array(
		'個人事業主' => '個人事業主',
		'共同経営' => '共同経営',
		'会社' => '会社',
		'その他の会社組織' => 'その他の会社組織',
		'国・地方公共団体' => '国・地方公共団体',
	);
}

function getSkills(){
	return [
		'制作用ツール、DTPソフト' => [
			'Photoshop' => 'Photoshop',
			'Illustrator' => 'Illustrator',
			'Dreamweaver' => 'Dreamweaver',
			'Wordpress' => 'Wordpress',
			'Flash' => 'Flash',
		],
		'デザイン技術' => [
			'Webデザイン' => 'Webデザイン',
			'グラフィックデザイン' => 'グラフィックデザイン',
			'3Dデザイン' => '3Dデザイン',
		],
		'開発技術' => [
			'IT・Web系技術' => 'IT・Web系技術',
			'アプリケーション開発技術' => 'アプリケーション開発技術',
		],
		'基本事務ソフト' => [
			'Excel' => 'Excel',
			'Power Point' => 'Power Point',
			'Words' => 'Words',
		],
		'ビジネススキル' => [
			'事務スキル' => '事務スキル',
			'営業スキル' => '営業スキル',
			'コンサルティング' => 'コンサルティング',
			'経営スキル' => '経営スキル',
			'企画力' => '企画力',
			'交渉力' => '交渉力',
			'マーケティング' => 'マーケティング',
			'プレゼンテーション' => 'プレゼンテーション',
			'プロジェクト・マネージメント' => 'プロジェクト・マネージメント',
			'情報収集力' => '情報収集力',
		],
		'語学' => [
			'英語' => '英語',
			'中国語' => '中国語',
			'韓国語' => '韓国語',
			'フランス語' => 'フランス語',
			'スペイン語' => 'スペイン語',
		],
	];
}

function getPrefectures(){
	return array(
		'北海道' => '北海道',
		'青森県' => '青森県',
		'岩手県' => '岩手県',
		'宮城県' => '宮城県',
		'秋田県' => '秋田県',
		'山形県' => '山形県',
		'福島県' => '福島県',
		'茨城県' => '茨城県',
		'栃木県' => '栃木県',
		'群馬県' => '群馬県',
		'埼玉県' => '埼玉県',
		'千葉県' => '千葉県',
		'東京都' => '東京都',
		'神奈川県' => '神奈川県',
		'新潟県' => '新潟県',
		'富山県' => '富山県',
		'石川県' => '石川県',
		'福井県' => '福井県',
		'山梨県' => '山梨県',
		'長野県' => '長野県',
		'岐阜県' => '岐阜県',
		'静岡県' => '静岡県',
		'愛知県' => '愛知県',
		'三重県' => '三重県',
		'滋賀県' => '滋賀県',
		'京都府' => '京都府',
		'大阪府' => '大阪府',
		'兵庫県' => '兵庫県',
		'奈良県' => '奈良県',
		'和歌山県' => '和歌山県',
		'鳥取県' => '鳥取県',
		'島根県' => '島根県',
		'岡山県' => '岡山県',
		'広島県' => '広島県',
		'山口県' => '山口県',
		'徳島県' => '徳島県',
		'香川県' => '香川県',
		'愛媛県' => '愛媛県',
		'高知県' => '高知県',
		'福岡県' => '福岡県',
		'佐賀県' => '佐賀県',
		'長崎県' => '長崎県',
		'熊本県' => '熊本県',
		'大分県' => '大分県',
		'宮崎県' => '宮崎県',
		'鹿児島県' => '鹿児島県',
		'沖縄県' => '沖縄県',
	);
}

function getBookingTotalPersonArray() {
	return array(
			'1' => '1人',
			'2' => '2人',
			'3' => '3人',
			'4' => '4人',
			'5' => '5人',
			'6' => '6人',
	);
}

function getReviewTabMapper(){
	return array(
		'0_all' => trans('reviews.review_all_reviews'),
		'1_waiting_owner' => trans('reviews.review_waiting_owner'),
		'2_posted_owner' => trans('reviews.review_posted_owner'),
		'3_waiting_partner' => trans('reviews.review_waiting_partner'),
		'4_posted_partner' => trans('reviews.review_posted_partner'),
	);
}

function getUserSexMapper() {
	return array(
		USER_SEX_MALE => '男性',
		USER_SEX_FEEMALE => '女性',
	);
}

function getUserAgeMapper() {
	return array(
		USER_AGE_20S => trans("common.20's"),
		USER_AGE_30S => trans("common.30's"),
		USER_AGE_40S => trans("common.40's"),
		USER_AGE_50S => trans("common.50's"),
		USER_AGE_60S => trans("common.60's"),
		USER_AGE_70S => trans("common.70's"),
	);
}

function getReviewTabName($index) {
	$reviewTabs = getReviewTabMapper();
	return $reviewTabs[$index];
}
function getSqlQuery($object, $return = true) {
	$query = $object->toSql();
	$binding = $object->getBindings();
	$aExplode = explode('?', $query);
	foreach ($aExplode as $index => &$value)
	{
		if ($index == count($aExplode)  - 1) continue;
		$value .= "'". $binding[$index] ."'";

	}
	$sql = implode(' ', $aExplode);
	if ($return)
		return $sql;
	else {
		echo '<pre>';
		print_r($sql);
		die;
	}
}

function showWidthRatingProgress($point, $max = 5)
{
	$width = $point*100 / $max;
	return $width;
}

function getAllNotificationTypes ($userType = 0)
{
	$aType = array(
		NOTIFICATION_SPACE,
		NOTIFICATION_FAVORITE_SPACE,
		NOTIFICATION_REVIEW_BOOKING,
	);
	if ($userType == 1)
	{
		$aType[] = NOTIFICATION_BOOKING_PLACED;
	}
	return $aType;
}

function sendEmailCustom ($params){
	// Send email to admin
	global $from, $sendTo, $subject;
	$sendTo = (array)@$params['sendTo'];
	if (env('APP_ENV') != ENV_PRODUCTION)
	{
		$sendTo[] = 'quocthang.2001@gmail.com';
		$sendTo[] = 'kyoko@heart-hunger.com';
	}
	$template = @$params['template'];
	$subject = @$params['subject'];
	$from = Config::get('mail.from');
	
	// Send email to Shared User ( User 1)
	Mail::send($template,$params,
	function ($message) {
		global $from, $sendTo, $subject;
		$message->from($from['address'], $from['name']);
		$mails = $sendTo;
		$message->to($mails)->subject($subject);
	});
}

function getPaymentMethod($rent_data)
{
	switch ($rent_data->payment_method)
	{
		case "creditcard" :
			return 'クレジットカード';
			break;
		case "paypal" :
			return 'Paypal';
			break;
	}
}

function showStarReview($review, $showText = true)
{
if (!isset($review['average']) && !isset($review['AverageRating']) && !isset($review['0']))
	{
		$average = 0;
		$count = 0;
	}else {
		if (isset($review[0]))
		{
			$average = 0;
			foreach ($review as $myReview)
			{
				$average += $myReview['AverageRating'];
			}
			$count = (int)count($review);
			$average = $average / $count;
		}
		else{
			$average = isset($review['average']) ? $review['average'] : @$review['AverageRating'];
			$count = (int)@$review['count'];
		}
	}
	?>
	<span class="Rating Rating--labeled" data-star_rating="<?php echo @number_format($average, 1)?>">
		<span class="Rating-total"> <span class="Rating-progress" style="width:<?php echo showWidthRatingProgress($average)?>%"></span>
		</span> 
		<?php if ($showText) {?>
		<span class="Rating-review"><?php echo $count?>レビュー</span>
		<?php }?>
	</span>
<?php
}

function getFullUrl($except = array())
{
	$url = Request::url();
	return $url . (count($except) ? '?'. urldecode(http_build_query($except, 'flags_')) : '');
}

function getDataTableTranslate(){
	$translate = array();
	$translate['info'] = '件中、_PAGE_ 件を表示 _PAGES_';
	$translate['pageLength'] = 25;
	$translate['info'] = false;
	$translate['language'] = array();
	$translate['language']['search'] = '検索';
	$translate['language']['lengthMenu'] = '表示件数: _MENU_';
	$translate['language']['paginate'] = array();
	$translate['language']['emptyTable'] = 'データはありません';
	$translate['language']['emptyTable'] = 'データはありません';
	$translate['language']['paginate']['previous'] = '前';
	$translate['language']['paginate']['next'] = '次';

	$json = json_encode($translate);
	$json = substr($json, 1, strlen($json));
	$json = substr($json, 0, strlen($json) - 1);
	return $json;
}

function isUserOnline($user)
{
	$ilast_activity = \Carbon\Carbon::now()->subSeconds('1500');
	return $user->LastActivity >= $ilast_activity ? true : false;
}

function cleanTempFiles($source, $pastDate)
{
	if (!file_exists($source)) return;
	$list = glob($source . "/*");
	foreach ($list as $file) {
		if (date('Y-m-d', filemtime($file)) <= $pastDate->format('Y-m-d'))
		{
			unlink($file);
		}
	}
}

function cleanTemporaryData(){
	// Number date Before current day
	$pastDateNumber = 1;
	
	$oTimeNow = \Carbon\Carbon::now();
	$oTimeNow->subDays($pastDateNumber);
	
	$tempFolders = array(
		public_path() . '/images/space/tmp',
		public_path() . '/images/portfolio/tmp',
		public_path() . '/images/avatars/tmp',
	);
	foreach ($tempFolders as $tempFolder)
	{
		cleanTempFiles($tempFolder, $oTimeNow);
	}
	
	// Clearn temp draft data in data table : rentbookingsaves
	DB::statement('DELETE FROM rentbookingsaves WHERE status = 5 AND updated_at <= "'. $oTimeNow->format('Y-m-d H:i:s') .'"');
}

function renderSocialScript(){
	?>
	<div class="social_buttons_wraper" style="display: none;">
		<div class="social_buttons">
			<div class="addthis_inline_share_toolbox_nvxa addthis_content"></div>
		</div>
	</div>
	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-581c2acbdd53e2e7"></script>
<?php
}

function renderOfferPopup($user){
?>
	<div class="modal fade" id="popover_offer_wrapper" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" ><?=trans("common.Offer List")?></h4>
				</div>
				<div class="modal-body" id="modal-offerlist">
					<div class="crop_set_preview">
						<div class="crop_preview_left">
							<div class="upload_portfolio_success" style="display: none;"></div>
							<div class="upload_portfolio_message_error upload_message_error" style="display:none"></div>
							<form class="offer_list_form" method="post" action="<?php echo URL::to("RentUser/SaveSpaceOffers")?>" name="offer_form">
								<input type="hidden" name="userSendId" value="<?php echo $user->id?>" id="userSendId"/>
								<input type="hidden" name="userReceiveId" value="" id="userReceiveId"/>
								<input type="hidden" name="_token" value="<?php echo csrf_token()?>">
								<div id="offer_list_content"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php	
}


function renderErrorSuccessHtml(Illuminate\Support\ViewErrorBag $errors)
{
?>
	<?php if (session()->has('error')) {?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo session()->get('error')?>
	</div>
	<?php }elseif (session()->has('success')) {?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo session()->get('success')?>
	</div>
	<?php }elseif (session()->has('suc')) {?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo session()->get('suc')?>
	</div>
	<?php }?>
	
	<?php if ($errors->count() > 0) {?>
	<div class="form-error">
		<ul>
			<?php foreach($errors->all() as $error) { ?>
			<li><?php echo $error?></li>
			<?php }?>
		</ul>
	</div>
	<?php }?>
<?php
}

function forceUserReview() {
	// Check the completed booking, if has go to write review page
	$currentAction = Route::currentRouteAction();
	
	if ( (Auth::guard('user1')->check() || Auth::guard('user2')->check()) && 
			Request::method() == 'GET' &&
			! Request::ajax() && 
			! in_array($currentAction, array(
				'App\Http\Controllers\User2Controller@review',
				'App\Http\Controllers\User2Controller@writeReview',
				'App\Http\Controllers\User1Controller@review',
				'App\Http\Controllers\User1Controller@writeReview',
	)))
	{
		$user = Auth::guard('user1')->check() ? Auth::guard('user1')->user() : Auth::guard('user2')->user();
		$szUserID = Auth::guard('user1')->check() ? 'User1ID' : 'user_id';
		$szUser = Auth::guard('user1')->check() ? 'User1' : 'User2';
		
		$oWaitingReview = new \App\Rentbookingsave();
		$oWaitingReview = $oWaitingReview->select('rentbookingsaves.id');
		$oWaitingReview = $oWaitingReview->join('user1sharespaces', 'rentbookingsaves.user1sharespaces_id', '=', 'user1sharespaces.id');
		$oWaitingReview = $oWaitingReview->where('rentbookingsaves.status', BOOKING_STATUS_COMPLETED)->where("rentbookingsaves.$szUserID", $user->id);
		$oWaitingReview = $oWaitingReview->whereRaw(DB::raw('rentbookingsaves.id NOT IN (SELECT BookingID From userreviews WHERE '.$szUserID.' = ' . $user->id . ' AND ReviewedBy="'.$szUser.'")'));
		$waitingReviews = $oWaitingReview->get();
		
		if ( count($waitingReviews) >= 1 )
		{
			if ( count($waitingReviews) == 1 )
			{
				// Go to Write review page with number booking ID
				Session::flash('success', trans('common.Please complete the reviews before browse other pages'));
				if (Auth::guard('user1')->check())
					Redirect::to(getSharedFeedbackUrl($waitingReviews[0]['id']))->send();
				else
					Redirect::to(getRentFeedbackUrl($waitingReviews[0]['id']))->send();
			}
			else
			{
				// Go to Review list page
				Session::flash('success', trans('common.Please complete the reviews before browse other pages'));
				if (Auth::guard('user1')->check())
					Redirect::to(getShareReviewListUrl())->send();
				else
					Redirect::to(getRentReviewListUrl())->send();
			}
		}
	}
	return false;
}