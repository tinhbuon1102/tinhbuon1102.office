@extends('adminLayout')
@section('head')
    <title>シェアユーザー詳細</title>
@stop
@section('PageTitle')
	シェアユーザー詳細
@stop
@section('Content')
	
	<div class="row user-view">
    <div class="info-col">
   <h3>個人情報</h3>
   
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>お名前</label>
         <p class="form-control-static">{{ $user1->LastName }} {{ $user1->FirstName }}</p>
    </div>
   </div>
   
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>メールアドレス</label>
         <p class="form-control-static">{{ $user1->Email }}</p>
    </div>
   </div>
   </div><!--/info-col-->
   <div class="info-col">
   <h3>会社情報</h3>
      <div class="col-xs-12 col-sm-4 col-1">
	<div class="form-group">
         <label>会社名</label>
         <p class="form-control-static">{{ $user1->NameOfCompany }}</p>
    </div>
   </div>
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>郵便番号</label>
         <p class="form-control-static">{{ $user1->PostalCode }}</p>
    </div>
   </div>
   
   <div class="col-xs-12 col-sm-4 col-2">
	<div class="form-group">
         <label>住所</label>
         <p class="form-control-static">{{ $user1->Address }}</p>
    </div>
   </div>
   
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>電話番号</label>
         <p class="form-control-static">{{ $user1->Tel }}</p>
    </div>
   </div>
      <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>会社サイトURL</label>
         <p class="form-control-static">
			@if($user1->WebUrl=="http://")
				無し
			@else	
		 {{ $user1->WebUrl }}
			@endif
		 </p>
    </div>
   </div>
   </div><!--/info-col-->
   <div class="info-col">
      <h3>その他</h3>
   <div class="col-xs-12 col-sm-4">
	<div class="form-group">
         <label>メルマガ購読</label>
         <p class="form-control-static">
		 @if($user1->Newsletter=="Yes")
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
