<?php
function getSpaceUrl($hashCode) {
	return url('/') . '/ShareUser/ShareInfo/View/' . $hashCode;
}

function getRentFeedbackUrl($bookingID) {
	return url('/RentUser/Dashboard/Review/Write/' . $bookingID);
}

function getSharedFeedbackUrl($bookingID) {
	return url('/ShareUser/Dashboard/Review/Write/' . $bookingID);
}

function getSharedBookingDetailUrl($bookingID) {
	return url('/ShareUser/Dashboard/EditBook/' . $bookingID);
}

function getRentBookingDetailUrl($bookingID) {
	return url('/RentUser/Dashboard/Reservation/View/' . $bookingID);
}

function getSharedBookingListUrl() {
	return url('/ShareUser/Dashboard/BookList');
}

function getRentBookingListUrl() {
	return url('/RentUser/Dashboard/Reservation');
}


function getUser1ProfileUrl($user) {
	$hasCode = isset($user->HashCode) ? $user->HashCode : $user['HashCode'];
	return url('/') . '/ShareUser/HostProfile/View/' . $hasCode;
}

function getUser2ProfileUrl($user) {
	if (isset($user->HashCode))
	{
		return url('/') . '/RentUser/Profile/' . $user->HashCode . '/' . $user->LastName . '-' . $user->FirstName;
	}
	else {
		return url('/') . '/RentUser/Profile/' . $user['HashCode'] . '/' . $user['LastName'] . '-' . $user['FirstName'];
	}
}

function getHostMemberPhoto($user)
{
	if(!empty($user->HostPhoto) && file_exists(public_path() . '/' . $user->HostPhoto))
		$logo = $user->HostPhoto;
	else
		$logo = '/images/man-avatar.png';

	return $logo;
}

function getSpacePhoto($space, $smallThumb = false)
{
	$logo = '';
	if(!empty($space->spaceImage))
	{
		foreach ($space->spaceImage as $image)
		{
			$thumb = $smallThumb ? $image->SThumbPath : $image->ThumbPath;
			if($image->Main && file_exists(public_path() . '/' . $thumb))
			{
				$logo = $thumb;
			}
		}
	}
	$logo = $logo ? $logo : '/images/space-sample.jpg';
	return $logo;
}

function getUser2Photo($id)
{
	if (!is_object($id))
		$user=\App\User2::where('HashCode','=', $id)->first();
	else
		$user = $id;

	if(!empty($user->Logo) && file_exists(public_path() . '/' . $user->Logo))
		$logo=$user->Logo;
	elseif($user->Sex=='女性')
	$logo='/images/woman-avatar.png';
	else
		$logo='/images/man-avatar.png';

	return $logo;
}

function getUser1Photo($id)
{
	if (!is_object($id))
		$user=\App\User1::where('HashCode','=', $id)->first();
	else
		$user = $id;

	if(!empty($user->Logo) && file_exists(public_path() . '/' . $user->Logo))
		$logo=$user->Logo;
	elseif($user->Sex=='女性')
	$logo='/images/woman-avatar.png';
	else
		$logo='/images/man-avatar.png';

	return $logo;
}