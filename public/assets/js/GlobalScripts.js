function authNetEventProxy(name,params){switch(name){case"successfulSave":$(document).trigger("successAuthorizeNetPopup");break;case"cancel":$(document).trigger("cancelAuthorizeNetPopup");break;case"resizeWindow":$(document).trigger("resizeAuthorizeNetPopup",params)}}function initPlaid(params){var options=$.extend({url:"/Calendar/ExchangePlaidToken",onSuccess:function(){},urlParams:{}},params);return Plaid.create({selectAccount:!0,env:"production",clientName:"LiquidSpace",key:"bf7e2ae4145508ea0340fc2d560cd6",product:"auth",onLoad:function(){},onSuccess:function(public_token,metadata){LSHelper.HelperLib.blockUI();var url=options.url+"?publicToken="+public_token+"&accountId="+metadata.account_id;options.urlParams&&(url+="&"+$.param(options.urlParams));$.ajax({type:"GET",url:url,success:function(result){if(result&&!result.success){LSHelper.Dialog.confirmDialog(result.error,function(){},"Account linking failed.");return}options.onSuccess&&options.onSuccess()},complete:function(){LSHelper.HelperLib.unblockUI()}})},onExit:function(){}})}function applyButtonPermissions(){$("button.permission-pending").button({disabled:!0,label:"Permission Pending"});$("button.permission-denied").button({disabled:!0,label:"Permission Denied"});$("button.unavailable").button({disabled:!0,label:"Not Available"});$("button.permission-pending, button.permission-denied, button.unavailable").width("auto").height("auto")}function isTouchDevice(){return"ontouchstart"in window||"msmaxtouchpoints"in window.navigator}function initUI(){LSHelper.HelperLib.setOptionalText($("[placeholder]"));applyButtonPermissions();$("button, input:submit, input:button, .dhx_btn_set").button();$(".date_time").datepicker({option:$.datepicker.regional["en-US"],dateFormat:"m/d/yy",showOn:"button",buttonImage:"https://lsprodcontent.azureedge.net/images/icons/calendar-icon.png?v=-1215027205",buttonImageOnly:!0,onSelect:function(){$("form").each(function(id,data){$(data).valid()})}})}function GetUrl(action,controller){return("//"+controller+"/"+action).replace(/\/+/,"/")}function GetApplicationUrl(){return"/"}function stopRKey(evt){var evt=evt?evt:event?event:null,node=evt.target?evt.target:evt.srcElement?evt.srcElement:null;if(evt.keyCode==13&&node.type=="text")return!1}document.function_SSO_accountLinking_Completed=function(ns,errors){$(document).trigger("SSO_accountLinking_Completed."+ns,[errors]);$(document).trigger("SSO_accountLinking_Completed",{sso:ns,errors:errors})};jQuery(document).ready(function($){mobileDeviceType="Unsupported";var vgid=LSHelper.HelperLib.getUrlVars().vgid;vgid!=null&&LSHelper.sessionStorage.set("ExclusiveHotelsVenueGroupId",vgid);LSHelper.SessionCoupon.trackCoupon();checkPageRefresh();$.browser.msie&&$("html").addClass("IE");($.cookie("__lsreferrer")==null||$.cookie("__lsreferrer").length==0)&&$.cookie("__lsreferrer",encodeURIComponent(document.referrer));isTouchDevice()&&$("html").addClass("touch");initUI();LSHelper.HelperLib.manageFooterSignUp("email address");window.onBeforeunload=function(){LSHelper.HelperLib.blockUI()};$(window).unload(function(){LSHelper.HelperLib.unblockUI()});window.onload=function(){handleBackButton(!1)};$(document).ajaxError(function(e,xhr){var response,obj;if(xhr!=undefined&&xhr.status==530)if(typeof document.notLoggedInCallBack!="undefined"&&document.notLoggedInCallBack!=null&&$.isFunction(document.notLoggedInCallBack))document.notLoggedInCallBack();else try{response=JSON.parse(xhr.responseText);window.location=response&&response.RedirectTo?response.RedirectTo:xhr.responseText}catch(ex){window.location=xhr.responseText}else if(xhr!=undefined){$.unblockUI();obj=null;try{obj=JSON.parse(xhr.responseText)}catch(e){DEBUG&&console.log(e)}xhr.status!=404&&xhr.status!=0&&(obj!=null&&obj.code&&obj.code==1?LSHelper.Sso.popupSsoLogin("/"+obj.url,700,350):LSHelper.UI.showError(obj))}});$(document).ajaxStop(function(){initUI()});$.ajaxSetup({cache:!1,async:!0})});document.onkeypress=stopRKey