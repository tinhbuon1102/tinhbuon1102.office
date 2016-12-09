<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* STATIC PAGES */
Route::get('/', function () {
    return 'Coming Soon ....';
});
Route::get('/', 'PublicController@landingPage');

Route::get('/how-it-works', function () {
    return view('pages.howitwork');
});


Route::get('/TermCondition', function () {
    return view('pages.term_condition');
});
Route::get('/TermCondition/RentUser', function () {
    return view('pages.term_condition_rentuser');
});
Route::get('/TermCondition/ShareUser', function () {
    return view('pages.term_condition_shareuser');
});

Route::get('/help', function () {
    return view('pages.help');
});
Route::any('/help/rentuser/{subUrl?}', "PageController@helpUser");
Route::any('/help/shareuser/{subUrl?}', "PageController@helpUser");
Route::any('/help/guest/{subUrl?}', "PageController@helpUser");


Route::get('/how-it-works/find-space', function () {
    return view('pages.howitwork_findspace');
});

Route::get('/how-it-works/list-space', function () {
    return view('pages.howitwork_listspace');
});

Route::get('/how-it-works/manage-booking', function () {
    return view('pages.howitwork_managebooking');
});

Route::get('PrivacyPolicy', "PageController@privacyPolicy");
Route::get('cookie-policy', "PageController@cookiePolicy");
Route::any('list-service', "PageController@listService");
Route::get('cancel-policy', "PageController@cancelPolicy");


/*Route::get('myAdmin', function () {
    return view('adminLayout');
});*/

//***************** ADMIN **************************

Route::get('MyAdmin/Login', "MyAdminController@login");

Route::get('lp/public/MyAdmin/Login',"MyAdminController@login");
Route::post('MyAdmin/Login/Validate', "MyAdminController@validateMyAdmin");


Route::get('MyAdmin/Dashboard', "MyAdminController@dashboard");
Route::get('MyAdmin/User1', "MyAdminController@user1");
Route::get('MyAdmin/User1/Approve/{user1}', "MyAdminController@user1approve");
Route::get('MyAdmin/User1/Send/{user1}', "MyAdminController@sendmail");
Route::get('MyAdmin/User1/sendUser1EmailVerify/{user}', "MyAdminController@sendUser1EmailVerify");
Route::get('MyAdmin/User1/View/{user1}', "MyAdminController@view");
Route::post('MyAdmin/User1/DeleteM', "MyAdminController@deletemuser1");
Route::get('MyAdmin/Spaces', "MyAdminController@Spaces");
Route::post('MyAdmin/Spaces', "MyAdminController@Spaces");

Route::get('MyAdmin/User2', "MyAdminController@user2");
Route::get('MyAdmin/User2/View/{user2}', "MyAdminController@view2");
Route::get('MyAdmin/User2/Approve/{user2}', "MyAdminController@user2approve");
Route::get('MyAdmin/User2/sendUser2EmailVerify/{user}', "MyAdminController@sendUser2EmailVerify");
Route::post('MyAdmin/User2/DeleteM', "MyAdminController@deletemuser2");

Route::get('MyAdmin/Test', "MyAdminController@test");

Route::get('MyAdmin/Logout', "MyAdminController@logout");

Route::get('MyAdmin/SpaceList', "MyAdminController@spaceList");

Route::get('MyAdmin/ShareUser/{id}', "MyAdminController@shareUser");
Route::post('MyAdmin/ShareUser/{id}', "MyAdminController@hostSettingSubmit");
Route::get('MyAdmin/ShareUser/Dashboard/EditBook/{id}', "MyAdminController@editBooking");
Route::post('MyAdmin/ShareUser/Dashboard/EditBookSave/{id}', "MyAdminController@EditBookSave");

Route::post('MyAdmin/ShareUser/{id}/BankInfo', "MyAdminController@SaveBankInfo");
Route::post('MyAdmin/ShareUser/{id}/HostInfo', "MyAdminController@SaveHostInfo");
Route::post('MyAdmin/ShareUser/{id}/UploadImage', "User1Controller@dashboardHostSettingUpload");

Route::get('MyAdmin/ShareUser/{id}/SpaceList', "MyAdminController@shareUserSpaceList");
Route::get('MyAdmin/ShareUser/{id}/AddSpace', "MyAdminController@shareUserAddSpace");
Route::post('MyAdmin/ShareUser/{id}/AddSpace', "MyAdminController@shareUserAddSpaceSubmit");
Route::get('MyAdmin/ShareUser/{id}/EditSpace/{space}', "MyAdminController@shareUserEditSpace");
Route::post('MyAdmin/ShareUser/{id}/EditSpace/{space}', "MyAdminController@shareUserEditSpaceSubmit");
Route::get('MyAdmin/ShareUser/{id}/Certificate', "MyAdminController@Certificate");
Route::get('MyAdmin/ShareUser/{id}/Invoice/{invoiceID}', "MyAdminController@shareUserInvoiceDetail");

Route::get('MyAdmin/RentUser/{id}', "MyAdminController@rentUser");
Route::post('MyAdmin/RentUser/{id}', "MyAdminController@rentUserSubmit");
Route::get('MyAdmin/RentUser/{id}/Identify', "MyAdminController@Identify");
Route::get('MyAdmin/RentUser/{id}/Invoice/{invoiceID}', "MyAdminController@rentUserInvoiceDetail");
Route::get('MyAdmin/RentUser/{id}/Reservation/{BookingID}', "MyAdminController@rentUserReservationDetail");
Route::post('MyAdmin/RentUser/{id}/CancelPayment', "MyAdminController@rentUserCancelPayment");

Route::get('MyAdmin/Sales', "MyAdminController@sales");
Route::get('MyAdmin/Sales/{id}', "MyAdminController@salesIndividual");


//***************** USER1 **************************

/*Route::get('RegisterUser1', "User1Controller@register");

Route::post('RegisterUser1/Save',"User1Controller@save" );*/

Route::get('User2/Login', "User2Controller@login");
Route::get('user2/getajaxhour', "User2Controller@getajaxhour");
Route::post('User2/Validate', "User2Controller@isvalid");

Route::get('User1/Login', "User1Controller@login");
Route::post('User1/Validate', "User1Controller@isvalid");


Route::get('User1/Logout', "User1Controller@logout");
Route::get('User2/Logout', "User2Controller@logout");

Route::get('Chat/EmailNotification', "PageController@chatNotification");


Route::get('FBLoginRedirect', 'FacebookController@redirect');
Route::get('FBLogin', 'FacebookController@callback');
Route::post('FBLogin', 'FacebookController@register');
Route::get('test', "User1Controller@test");
Route::get('test1', "PageController@test1");
Route::get('ShareUser', "User1Controller@index");
Route::get('lp/public', "User1Controller@index");
Route::get('Register-ShareUser', "User1Controller@registerShareUser");
Route::post('Register-ShareUser/Step2',"User1Controller@step2" );
Route::get('Register-ShareUser/Step2',"User1Controller@step2" );

Route::post('Register-ShareUser/SaveUser',"User1Controller@saveUser" );

Route::get('Register-ShareUser/ThankYou',"User1Controller@thankyou" );
Route::post('Register-ShareUser/Confirm',"User1Controller@confirm" );
Route::get('Register-ShareUser/VerifyEmail/{id}',"User1Controller@verifyEmail" );
Route::get('ShareUser/Dashboard/VerifyEmail/{id}',"User1Controller@verifyEmail" );
Route::get('ShareUser/Dashboard/SendVerifyEmail',"PageController@user1SendEmailVerificationLink" );

/*home register*/
Route::get('ShareUser/BasicInfo', "User1Controller@basicInfo");
Route::post('ShareUser/BasicInfo', "User1Controller@basicInfoSubmit");
Route::get('ShareUser/RegisterPreSuccess', "User1Controller@registerPreSuccess");
Route::get('ShareUser/RegisterSuccess', "User1Controller@registerSuccess");
Route::get('ShareUser/ShareInfo', "User1Controller@shareInfo");
Route::post('ShareUser/deleteSpaceImage', "User1Controller@deleteSpaceImage");
Route::post('ShareUser/ShareInfo/UploadImage', "User1Controller@dashboardshareInfoUpload");

Route::get('ShareUser/Dashboard', "User1Controller@dashboard");
Route::get('ShareUser/Dashboard/RecommendUser', "User1Controller@RecommendUser");
Route::get('ShareUser/Dashboard/MyPage', "User1Controller@myPage");
Route::get('ShareUser/Dashboard/InvoiceList', "User1Controller@invoiceList");
Route::get('RentUser/Dashboard/InvoiceList', "User2Controller@invoiceList");
Route::get('ShareUser/Dashboard/InvoiceList/Detail/{id}', "User1Controller@invoiceDetail");
Route::get('RentUser/Dashboard/InvoiceList/Detail/{id}', "User2Controller@invoiceDetail");
Route::get('ShareUser/Dashboard/OfferList', "User1Controller@offerList");
Route::get('ShareUser/Dashboard/BasicInfo', "User1Controller@dashboardbasicInfo");
Route::get('ShareUser/Dashboard/ShareInfo', "User1Controller@dashboardshareInfo");

Route::post('ShareUser/ShareInfo', "User1Controller@dashboardshareInfoSubmit");
Route::post('ShareUser/ShareInfo/{id}', "User1Controller@shareInfoEditSubmit");
Route::post('ShareUser/Dashboard/ShareInfo/UploadImage', "User1Controller@dashboardshareInfoUpload");
Route::get('ShareUser/Dashboard/ShareInfo/Edit/{id}', "User1Controller@editshareInfo");
Route::post('ShareUser/Dashboard/ShareInfo/Edit/{id}/UploadImage', "User1Controller@dashboardshareInfoUpload");
Route::get('ShareUser/Dashboard/ShareInfo/Duplicate/{id}', "User1Controller@duplicateShareInfo");
Route::get('ShareUser/Dashboard/ShareInfo/Delete/{id}', "User1Controller@deleteShareInfo");
Route::get('ShareUser/Dashboard/editspace/{id}', "User1Controller@editshareInfoBeforeLauncht");
Route::post('ShareUser/Dashboard/SaveCalendar', "User1Controller@shareInfoSaveCalendar");
Route::get('ShareUser/Dashboard/MySpace/List', "User1Controller@shareSpaceList");
Route::get('ShareUser/Dashboard/MySpace/List1', "User1Controller@shareSpaceList1");
Route::get('ShareUser/Dashboard/MySpace/Calendar', "User1Controller@shareSpaceCalendar");
Route::get('ShareUser/Dashboard/EditBook/{id}', "User1Controller@editBooking");
Route::post('ShareUser/Dashboard/EditBookSave/{id}', "User1Controller@EditBookSave");

Route::get('ShareUser/Dashboard/ThankYou', "User1Controller@thankyoudashboard");
Route::get('ShareUser/Dashboard/HostSetting', "User1Controller@hostSetting");
Route::get('ShareUser/Dashboard/DesiredPerson', "User1Controller@HostSettingDesiredPerson");
Route::get('ShareUser/Dashboard/HostSetting/Certificate', "User1Controller@Certificate");
Route::post('ShareUser/Dashboard/HostSetting/Certificate', "User1Controller@Certificate");

Route::post('ShareUser/Dashboard/HostSetting', "User1Controller@hostSettingSubmit");
Route::post('ShareUser/Dashboard/HostSetting/BankInfo', "User1Controller@SaveBankInfo");
Route::post('ShareUser/Dashboard/HostSetting/HostInfo', "User1Controller@SaveHostInfo");
Route::post('ShareUser/Dashboard/HostSetting/UploadImage', "User1Controller@dashboardHostSettingUpload");

Route::post('ShareUser/Dashboard/ChangePassword', "User1Controller@changePassword");
Route::post('RentUser/Dashboard/ChangePassword', "User2Controller@changePassword");

Route::post('ShareUser/Dashboard/ChangeEmail', "User1Controller@changeEmail");
Route::post('RentUser/Dashboard/ChangeEmail', "User2Controller@changeEmail");

Route::get('ShareUser/DesirePerson',"User1Controller@desiredPerson" );
Route::post('ShareUser/DesirePerson',"User1Controller@desiredPersonSubmit" );
Route::get('ShareUser/Dashboard/Message',"User1ChatController@message" );
Route::get('ShareUser/Dashboard/Message/{id}',"User1ChatController@messageUser" );
Route::get('ShareUser/Dashboard/GetMessage/{id}',"User1ChatController@getMessages" );
Route::get('ShareUser/Dashboard/GetInstantMessage/{id}',"User1ChatController@getInstantMessages" );
Route::get('ShareUser/Dashboard/GetInstantMessageUser/{id}',"User1ChatController@getInstantMessagesByUser" );
Route::post('ShareUser/Dashboard/SendMessage',"User1ChatController@sendMessage" );
Route::post('ShareUser/Dashboard/SendFile',"User1ChatController@sendFile" );

Route::get('chat/auth',"User1ChatController@auth" );
Route::post('chat/auth',"User1ChatController@auth" );

Route::get('ShareUser/ShareInfo/View/{id}', "PublicController@viewShareSpace");
Route::get('ShareUser/HostProfile/View/{id}', "PublicController@viewHostProfile");
Route::get('ShareUser/ShareInfo/BookingPopup', "User2Controller@viewShareSpaceBooking");

Route::get('chat/auth1',"User2ChatController@auth" );
Route::post('chat/auth1',"User2ChatController@auth" );
Route::get('RentUser/Dashboard/Message',"User2ChatController@message" );
Route::get('RentUser/Dashboard/Message/{id}',"User2ChatController@messageUser" );
Route::get('RentUser/Dashboard/GetMessage/{id}',"User2ChatController@getMessages" );
Route::get('RentUser/Dashboard/GetInstantMessage/{id}',"User2ChatController@getInstantMessages" );
Route::get('RentUser/Dashboard/GetInstantMessageUser/{id}',"User2ChatController@getInstantMessagesByUser" );

Route::post('RentUser/Dashboard/SendMessage',"User2ChatController@sendMessage" );
Route::post('RentUser/Dashboard/SendFile',"User2ChatController@sendFile" );


Route::get('RentUser/list', "PublicController@listRentUser");
Route::get('RentUser/district/{Prefecture}',"PublicController@listDistrict");
Route::get('RentUser/Profile/{id}/{name}', "PublicController@profile");
Route::get('ShareUser/Dashboard/BookList', "PublicController@RentBooking");

Route::get('ShareUser/Dashboard/BookingDetails', "User2Controller@bookingDetails");
Route::get('ShareUser/Dashboard/BookingSummary', "User2Controller@bookingSummary");
Route::post('ShareUser/Dashboard/BookingSummary', "User2Controller@bookingSummary");
Route::get('ShareUser/Dashboard/BookingPayment', "User2Controller@bookingPayment");
Route::get('ShareUser/Dashboard/CreditPayment', "User2Controller@creditPayment");
Route::post('ShareUser/Dashboard/CreditPayment', "User2Controller@creditPayment");
Route::get('ShareUser/Dashboard/doPaypalRecurring', "User2Controller@doPaypalRecurring");
Route::post('ShareUser/Dashboard/doPaypalRecurring', "User2Controller@doPaypalRecurring");

Route::post('ShareUser/Dashboard/acceptPayment', "User1Controller@acceptPayment");


Route::get('ShareUser/Dashboard/PaypalPayment', "PaypalController@PaypalPayment");
Route::post('ShareUser/Dashboard/PaypalPayment', "PaypalController@PaypalPayment");


Route::get('ShareUser/Dashboard/payment/paypal', "PaypalController@index");


Route::get('ShareUser/Dashboard/PaypalIpn', "PaypalController@PaypalIpn");
Route::post('ShareUser/Dashboard/PaypalIpn', "PaypalController@PaypalIpn");

#Route::get('ShareUser/Paypal/Reccuring/Success', "PaypalController@PaypalPayment");

Route::get('ShareUser/Dashboard/PaypalCancel', "PaypalController@PaypalCancel");
Route::post('ShareUser/Dashboard/PaypalCancel', "PaypalController@PaypalCancel");

Route::get('ShareUser/Dashboard/PaypalSuccess', "PaypalController@PaypalSuccess");
Route::post('ShareUser/Dashboard/PaypalSuccess', "PaypalController@PaypalSuccess");
Route::get('ShareUser/Dashboard/processBookingPaymentAuto', "User1Controller@processBookingPaymentAuto");

Route::get('RentUser/Dashboard/payment/paypal', "PaypalController@refrencepaypal");
Route::get('RentUser/Dashboard/BasicInfo/payment/paypal', "PaypalController@refrencepaypal");

Route::post('RentUser/Dashboard/BasicInfo/verifystep1', "PaypalController@paypalVerifyStep1");

Route::get('RentUser/Dashboard/payment/paypalVerifyStep2', "PaypalController@paypalVerifyStep2");
Route::post('RentUser/Dashboard/payment/paypalVerifyStep2', "PaypalController@paypalVerifyStep2");
 
Route::get('Paypal/verify/Step2Cancel', "PaypalController@paypalVerifyStep2Cancel");
Route::post('Paypal/verify/Step2Cancel', "PaypalController@paypalVerifyStep2Cancel");

Route::get('RentUser/ValidatePayment/success', "PaypalController@signupValidateSuccess");
Route::get('RentUser/ValidatePayment/cancel', "PaypalController@signupValidateCancel");

Route::post('RentUser/{id}/Dashboard/payment/Unauthorize', "PaypalController@paypalUnauthorize");


Route::post('Dashboard/payment/refundRequest', "PaypalController@refundRequest");
Route::post('Dashboard/payment/rejectRequest', "PaypalController@rejectRequest");



Route::post('Dashboard/payment/acceptpayment', "PaypalController@acceptPaymentRequest");
Route::get('paypalManageProfiles', "PaypalController@cancelExpiredProfile");

/**/
Route::get('test', "PaypalController@test");
/**/
Route::get('lp/public/Register-ShareUser', "User1Controller@registerShareUser");
Route::post('lp/public/Register-ShareUser/Step2',"User1Controller@step2" );
Route::get('lp/public/Register-ShareUser/Step2',"User1Controller@step2" );

Route::post('lp/public/Register-ShareUser/SaveUser',"User1Controller@saveUser" );

Route::get('lp/public/Register-ShareUser/ThankYou',"User1Controller@thankyou" );
Route::post('lp/public/Register-ShareUser/Confirm',"User1Controller@confirm" );
Route::get('lp/public/Register-ShareUser/VerifyEmail/{id}',"User1Controller@verifyEmail" );

Route::get('ShareUser/Dashboard/Review/', "User1Controller@review");
Route::get('ShareUser/Dashboard/Review/Write/{id}', "User1Controller@writeReview");
Route::post('ShareUser/Dashboard/Review/Write/{id}', "User1Controller@reviewSave");
/**/
//***************** USER2 **************************

Route::get('RentUser', "User2Controller@landing");
Route::get('Register-RentUser', "User2Controller@registerUser");
Route::post('Register-RentUser/Step2',"User2Controller@step2" );
Route::get('Register-RentUser/Step2',"User2Controller@step2" );

Route::post('Register-RentUser/SaveUser',"User2Controller@saveUser" );
Route::post('Register-RentUser/Confirm',"User2Controller@confirm" );

Route::get('Register-RentUser/ThankYou',"User2Controller@thankyou" );
Route::get('Register-RentUser/VerifyEmail/{id}',"User2Controller@verifyEmail" );
Route::get('RentUser/Dashboard/VerifyEmail/{id}',"User2Controller@verifyEmail" );
Route::get('RentUser/Dashboard/SendVerifyEmail',"PageController@user2SendEmailVerificationLink" );

/**/
Route::get('RentUser', "User2Controller@landing");
Route::get('lp/public/RentUser', "User2Controller@landing");
Route::get('lp/public/Register-RentUser', "User2Controller@registerUser");
Route::post('lp/public/Register-RentUser/Step2',"User2Controller@step2" );
Route::get('lp/public/Register-RentUser/Step2',"User2Controller@step2" );

Route::post('lp/public/Register-RentUser/SaveUser',"User2Controller@saveUser" );
Route::post('lp/public/Register-RentUser/Confirm',"User2Controller@confirm" );

Route::get('lp/public/Register-RentUser/ThankYou',"User2Controller@thankyou" );
Route::get('lp/public/Register-RentUser/VerifyEmail/{id}',"User2Controller@verifyEmail" );


/*Rent User home page*/

Route::get('RentUser/BasicInfo', "User2Controller@basicInfo");
Route::post('RentUser/BasicInfo', "User2Controller@basicInfoSubmit");
Route::get('RentUser/RegisterPreSuccess', "User2Controller@registerPreSuccess");
Route::get('RentUser/RegisterSuccess', "User2Controller@registerSuccess");
Route::get('RentUser/RequireSpace', "User2Controller@requireSpace");
Route::post('RentUser/RequireSpace', "User2Controller@requireSpaceSubmit");
Route::get('RentUser/ValidatePayment', "User2Controller@validatePayment");
Route::get('RentUser/Dashboard/Success', "User2Controller@successStep");


Route::get('RentUser/Dashboard', "User2Controller@dashboard");
Route::get('RentUser/Dashboard/MyPage', "User2Controller@myPage");
Route::get('RentUser/Dashboard/Favorite', "User2Controller@myPageFavorite");
Route::get('RentUser/Dashboard/OfferList', "User2Controller@offerList");
Route::get('RentUser/Dashboard/MyProfile1', "User2Controller@myProfile1");
Route::get('RentUser/Dashboard/MyProfile', "User2Controller@myProfileEdit");
Route::get('RentUser/Dashboard/MyPortfolio', "User2Controller@myPortfolio");
Route::post('RentUser/Dashboard/MyPortfolioSave', "User2Controller@myPortfolioSave");
Route::post('RentUser/Dashboard/MyProfile/Edit', "User2Controller@myProfileEditSubmit");
Route::post('RentUser/Dashboard/MyProfile/Edit2', "User2Controller@myProfileEditSubmit2");
Route::post('RentUser/Dashboard/MyProfile/UploadImage', "User2Controller@myProfileEditUpload");
Route::post('RentUser/Dashboard/MyProfile/CoverUpload', "User2Controller@myProfileCoverUpload");

Route::get('RentUser/Dashboard/EditMySpace', "User2Controller@editMySpace");
Route::get('RentUser/Dashboard/BasicInfo/Edit', "User2Controller@editBasicInfo");
Route::post('RentUser/Dashboard/BasicInfo/Edit', "User2Controller@editBasicInfoSubmit");

//Route::post('RentUser/Dashboard/MyProfile/Edit', "User2Controller@ShareuserDashboardPortfolio");

Route::get('RentUser/Dashboard/Review', "User2Controller@review");
Route::get('RentUser/Dashboard/Review/Write/{id}', "User2Controller@writeReview");
Route::post('RentUser/Dashboard/Review/Write/{id}', "User2Controller@reviewSave");

Route::get('RentUser/Dashboard/Reservation/View/{id}', "User2Controller@reservationView");
Route::post('RentUser/Dashboard/cancelPayment', "User2Controller@cancelPayment");
Route::get('RentUser/Dashboard/deleterecPayment', "User2Controller@deleterecPayment");
Route::get('RentUser/Dashboard/Reservation', "User2Controller@reservation");
Route::get('RentUser/Dashboard/SearchSpaces', "PublicController@searchSpaces");
Route::get('RentUser/AddFavoriteSpace/{id}', "User2Controller@addFavoriteSpace");
/**/
//**********************************************
Route::get('contact', "ContactController@contact");
Route::post('contact/send',"ContactController@send" );
Route::get('contact/thankyou',"ContactController@thankyou" );

/**/
Route::get('lp/public/contact', "ContactController@contact");
Route::post('lp/public/contact/send',"ContactController@send" );
Route::get('lp/public/contact/thankyou',"ContactController@thankyou" );
/**/
//**********************************************
Route::get('company', "CompanyController@company");
Route::get('lp/public/company', "CompanyController@company");


//*******************
Route::post('Register-User', "PageController@register");
Route::post('Login', "PageController@login");
Route::post('Forgetpassword', "PageController@forgetpassword");
Route::get('user1/password/reset/{token}', "PageController@user1reset");
Route::get('user2/password/reset/{token}', "PageController@user2reset");
Route::post('user1/password/reset/{token}', "PageController@user1resetsubmit");
Route::post('user2/password/reset/{token}', "PageController@user2resetsubmit");
/*Credit card transaction*/
Route::post('transaction/card-transaction', "User2Controller@cardTransaction");
Route::get('RentUser/GetSpaceOffers', "PublicController@getUserSpaceOffers");
Route::post('RentUser/SaveSpaceOffers', "PublicController@saveRentUserSpaceOffers");
Route::get('GetUserNotifications', "PublicController@getUserNotifications");
Route::get('BookingCompleted', "User2Controller@BookingCompleted");

Route::get('iframeMultipleUpload', "User1Controller@iframeMultipleUpload");
Route::get('ShareUser/Dashboard/HostSetting/hostingImages', "User1Controller@hostingImages");
Route::post('ShareUser/Dashboard/HostSetting/hostingImages', "User1Controller@hostingImages");
Route::delete('ShareUser/Dashboard/HostSetting/hostingImages', "User1Controller@hostingImages");

Route::get('RentUser/Dashboard/Identify/Upload', "User2Controller@IdentifyUpload");
Route::get('RentUser/Dashboard/Identify/Upload/Send', "User2Controller@IdentifySend");
Route::get('RentUser/Dashboard/Identify/Upload/Delete/{id}', "User2Controller@IdentifyDelete");
Route::post('RentUser/Dashboard/Identify/Upload', "User2Controller@IdentifyUploadSubmit");


Route::get('RentUser/Dashboard/NotAuth', "User2Controller@notAuth");
Route::get('ShareUser/Dashboard/NotAuth', "User1Controller@notAuth");
Route::get('checkSessionExpire', "PublicController@checkSessionExpire");
Route::get('getSpaceFlexiblePrice', "PublicController@getSpaceFlexiblePrice");
Route::get('getSpaceCalendar', "PublicController@getSpaceCalendar");
Route::get('getBookingPaymentInfo', "PublicController@getBookingPaymentInfo");

Route::get('lang/{locale}', function ($locale) {
	Session::set('locale', $locale);
    return Redirect::back();
    //
});
