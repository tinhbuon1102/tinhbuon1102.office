<?php
define('SPACE_STATUS_PUBLIC', 1);
define('SPACE_STATUS_PRIVATE', 2);
define('SPACE_STATUS_DRAFT', 3);
// ========================================= //
define('SPACE_FEE_TYPE_HOURLY', 1);
define('SPACE_FEE_TYPE_DAYLY', 2);
define('SPACE_FEE_TYPE_WEEKLY', 3);
define('SPACE_FEE_TYPE_MONTHLY', 4);

// ========================================= //
define('BOOKING_STATUS_PENDING', 1);
define('BOOKING_STATUS_RESERVED', 2);
define('BOOKING_STATUS_REFUNDED', 3);
define('BOOKING_STATUS_CALCELLED', 4);
define('BOOKING_STATUS_DRAFT', 5);
define('BOOKING_STATUS_COMPLETED', 6);
define('BOOKING_STATUS_NON_REFUNDABLE', 7);
define('BOOKING_STATUS_INUSE', 8);

// ========================================= //
define('SLOT_STATUS_AVAILABLE', 0);
define('SLOT_STATUS_BOOKED', 1);

// ========================================= //
define('BOOKING_IN_USE', 1);

define('BOOKING_REFUND_NO_CHARGE', 1);
define('BOOKING_REFUND_CHARGE_50', 2);
define('BOOKING_REFUND_CHARGE_100', 3);

// ================== WEBPAY ======================= //
define('WEPAY_SECRET_API_KEY', 'test_secret_ac709mfnrcLrdGUa3r4g95WZ');
define('WEPAY_PUBLIC_API_KEY', 'test_public_6wsgEFg2rgz17uJgEy7V2dnr');

// ==================== UPLOAD ===================== //
define('SITE_URL', url('/') . '/');
define('ROOT_PATH_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '');
define('UPLOAD_PATH_SPACE_TMP_URL', url('/images/space/tmp/') . '/');
define('UPLOAD_PATH_LOGO_URL', url('/images/user/') . '/');
define('UPLOAD_PATH_AVATAR_URL', url('/images/avatars/tmp') . '/');
define('UPLOAD_PATH_COVER', url('/images/covers') . '/');

// ==================== Sale Tabs ===================== //
define('CURRENT_YEAR', 'current_year');
define('LAST_MONTH', 'last_month');
define('THIS_MONTH', 'this_month');
define('LAST_WEEK', 'last_week');

// ==================== Notification ===================== //
define('NOTIFICATION_SPACE', 'Space');
define('NOTIFICATION_FAVORITE_SPACE', 'FavoriteSpace');
define('NOTIFICATION_REVIEW_BOOKING', 'ReviewBooking');
define('NOTIFICATION_BOOKING_PLACED', 'BookingPlaced');
define('NOTIFICATION_BOOKING_CHANGE_STATUS', 'BookingChangeStatus');
define('NOTIFICATION_BOOKING_REFUND_50', 'BookingRefund50');
define('NOTIFICATION_BOOKING_REFUND_100', 'BookingRefund100');
define('NOTIFICATION_BOOKING_REFUND_NO_CHARGE', 'BookingRefundNoCharge');


// ==================== LIMIT ===================== //
define('LIMIT_NOTIFICATION', 10);
define('LIMIT_OFFERS', 10);
define('LIMIT_REVIEWS', 5);
define('LIMIT_SPACES', 10);
define('LIMIT_INVOICE', 10);
define('LIMIT_BOOKING', 1000);
define('LIMIT_DASHBOARD_FEED', 15);
define('LIMIT_SPACE_HOME', 6);

// ==================== PAYPAL ===================== //
define('PAYPAL_APP_ID', 'APP-80W284485P519543T');
define('PAYPAL_APP_UN', 'quocthang.2001.japan_api1.gmail.com');
define('PAYPAL_APP_PW', 'UA4WC9XVN7CDWRLJ');
define('PAYPAL_APP_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AbQ5v1TJK2G5TmwZ.NqGFsN-Ru0M');
define('PAYPAL_SANDBOX', TRUE);
define('PAYPAL_MERCHANT_EMAIL', 'quocthang.2001.japan@gmail.com');
define('PAYPAL_NOTIFY_URL', url("/ShareUser/Dashboard/PaypalIpn") );

define('PAYPAL_RESPONSE_STATUS_PENDING', 'Pending');
define('PAYPAL_RESPONSE_STATUS_REJECTED', 'Voided');
define('PAYPAL_RESPONSE_STATUS_REFUNDED', 'Refunded');
define('PAYPAL_RESPONSE_STATUS_PARTIALLY_REFUNDED', 'PartiallyRefunded');
define('PAYPAL_RESPONSE_STATUS_COMPLETED', 'Completed');

define('PAYPAL_RESPONSE_STATUS_SUCCESS', 'Success');
define('PAYPAL_RESPONSE_STATUS_FAILED', 'Failure');
define('PAYPAL_RESPONSE_STATUS_CANCELLED', 'Cancelled');



// Complete
// [PAYMENTSTATUS] => Completed
// [PENDINGREASON] => None
// [REASONCODE] => None

// ==================== Common ===================== //
define('REVIEW_STATUS_AWAITING', 0);
define('REVIEW_STATUS_COMPLETE', 1);

define('BOOKING_TAX_PERCENT', 8);
define('BOOKING_CHARGE_FEE_PERCENT', 10);
define('BOOKING_MONTH_RECURSION_INITPAYMENT', 2); // Number of months need to pay, initial payment

define('DATE_TIME_DEFAULT_FORMAT', 'Y-m-d H:i:s');
define('DATE_DEFAULT_FORMAT', 'Y-m-d');
define('TIME_DEFAULT_FORMAT', 'H:i:s');
define('JS_CACHED_TIME', 10);

define('REQUIRE_MESSAGE_FIELD_TEXT', 'は、必ず指定してください。');

