@extends('adminLayout')
@section('head')
    <title>レントユーザー詳細</title>
@stop
@section('PageTitle')
	レントユーザー詳細
@stop
@section('Content')
	
	<div class="row user-view">
    <div class="info-col">
   <h3>個人情報</h3>
   
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>氏名</label>
         <p class="form-control-static">{{ $user2->LastName }} {{ $user2->FirstName }}</p>
    </div>
   </div>
   
    <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>氏名(かな)</label>
         <p class="form-control-static">{{ $user2->LastNameKana }} {{ $user2->FirstNameKana }}</p>
    </div>
   </div>
   
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>メールアドレス</label>
         <p class="form-control-static">{{ $user2->Email }}</p>
    </div>
   </div>
   </div><!--/info-col-->
   <div class="info-col">
   <h3>会社情報</h3>
     
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>郵便番号</label>
         <p class="form-control-static">{{ $user2->PostalCode }}</p>
    </div>
   </div>
   
   <div class="col-xs-12 col-sm-4 col-2">
	<div class="form-group">
         <label>住所</label>
         <p class="form-control-static">{{ $user2->Address }}</p>
    </div>
   </div>
   
   
   </div><!--/info-col-->
   <div class="info-col">
      <h3>その他</h3>
	  
	   <div class="col-xs-12 col-sm-4 ">
	<div class="form-group">
         <label>事業主タイプ</label>
         <p class="form-control-static">{{ $user2->UserType }}</p>
    </div>
   </div>
   
    <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>事業内容</label>
         <p class="form-control-static">{{ $user2->BusinessType }}</p>
    </div>
   </div>
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>メルマガ購読</label>
         <p class="form-control-static">
		 @if($user2->Newsletter=="Yes")
													はい
												@else
													いいえ
												@endif
		</p>
    </div>
   </div>
   </div><!--/info-col-->
	
	
 </div>
	
@stop
