
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_beforelogin.php');
 ?>
 @include('pages.header_beforelogin')
<!--/head-->
<body class="home">
<div class="viewport">
<!--nav-->

            <?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/header_nav_shareuser.php'); ?>
  @if(Auth::check())
  @include('pages.header_nav_shareuser')
  @elseif(Auth::guard('user2')->check())
  <?php $check_user=1; ?>
  @include('pages.header_nav_rentuser')
  @else
  @include('pages.before_login_nav')
  @endif

<!--/nav-->
<div class="hero-article hero-hiw-page ng-scope">
<div class="hero-article-content">
<h1 class="hero-article-title"><strong>キャンセルポリシー</strong></h1>
</div>
<div class="parallax-container"></div>
</div>

<div class="home-top">
<section id="howitwork" class="white">
<div class="container">
<div class="help-content">
<div class="help_header">
<h1>キャンセルポリシーについて</h1>
</div>
<p>hOur Officeでは、各利用タイプ別にキャンセルポリシーを定めています。<br/>必ず、予約前にキャンセルポリシーを確認し、予約申し込み、予約受付を行って下さい。<br/>以下のキャンセルポリシーは提供者側からキャンセルを行なった場合、利用者側からキャンセルを行なった場合の双方に適用されます。</p>
<div class="mgb-30">
<h4>時間毎タイプの利用予約の場合</h4>
<div class="help_body_content">
<p>時間毎利用タイプは、以下のキャンセル条件となります。</p>
<ol class="list-type-dot big-txt">
<li>利用開始日<strong>2日前</strong>までのキャンセルは<strong>100%返金</strong></li>
<li>利用開始日<strong>1日前</strong>までのキャンセルは<strong>50%返金</strong></li>
<li>利用開始時間<strong>24時間未満前</strong>までのキャンセルは<strong>返金不可</strong></li>
</ol>
<p class="strong-notice">※但し、予約した時点で、予約開始日時までの時間が24時間を下回っていた場合は、予約した時間から1時間以内であれば100%返金でのキャンセルが可能</p>
<div class="timeline-container hide-sm">
<div class="row clearfix">
<div class="col-sm-3 timeline-segment timeline-segment-refundable ">
        <div class="timeline-point">
          <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
            2日前
          </div>

          <div class="timeline-point-marker"></div>
            <div class="timeline-point-label">
              12月14日（水）
              <br>13:00
            </div>
        </div>
      </div>
      
      <div class="col-sm-3 timeline-segment timeline-segment-partly-refundable">
      <div id="second-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          1日前
        </div>
        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月15日（木）
            <br>13:00</div>
      </div>
    </div>
    
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          24時間未満前
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月15日（木）
            <br>13:01</div>
      </div>
    </div>
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          利用開始
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月16日（金）
            <br>13:00</div>
      </div>
    </div>
</div><!--/row-->
<div class="timeline-fineprint">例</div>
</div>
</div>
</div><!--/mgb-30-->
<div class="mgb-30">
<h4>日毎タイプの利用予約の場合</h4>
<div class="help_body_content">
<p>日毎利用タイプは、以下のキャンセル条件となります。</p>
<ol class="list-type-dot big-txt">
<li>利用開始日<strong>7日前</strong>までのキャンセルは<strong>100%返金</strong></li>
<li>利用開始日<strong>3日前</strong>までのキャンセルは<strong>50%返金</strong></li>
<li>利用開始時間<strong>3日未満前</strong>までのキャンセルは<strong>返金不可</strong></li>
</ol>
<p class="strong-notice">※但し、予約した時点で、予約開始日時までの時間が3日間を下回っていた場合は、予約した時間から1時間以内であれば100%返金でのキャンセルが可能</p>
<div class="timeline-container hide-sm">
<div class="row clearfix">
<div class="col-sm-3 timeline-segment timeline-segment-refundable ">
        <div class="timeline-point">
          <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
            7日前
          </div>

          <div class="timeline-point-marker"></div>
            <div class="timeline-point-label">
              12月9日（金）
              <br>9:00
            </div>
        </div>
      </div>
      
      <div class="col-sm-3 timeline-segment timeline-segment-partly-refundable">
      <div id="second-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          3日前
        </div>
        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月13日（火）
            <br>9:00</div>
      </div>
    </div>
    
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          3日未満前
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月13日（火）
            <br>9:01</div>
      </div>
    </div>
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          利用開始
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月16日（金）
            <br>9:00</div>
      </div>
    </div>
</div><!--/row-->
<div class="timeline-fineprint">例</div>
</div>
</div>
</div><!--/mgb-30-->
<div class="mgb-30">
<h4>週毎タイプの利用予約の場合</h4>
<div class="help_body_content">
<p>週毎利用タイプは、以下のキャンセル条件となります。</p>
<ol class="list-type-dot big-txt">
<li>利用開始日<strong>2週間前</strong>までのキャンセルは<strong>100%返金</strong></li>
<li>利用開始日<strong>1週間前</strong>までのキャンセルは<strong>50%返金</strong></li>
<li>利用開始時間<strong>1週間未満前</strong>までのキャンセルは<strong>返金不可</strong></li>
</ol>
<p class="strong-notice">※但し、予約した時点で、予約開始日時までの時間が1週間を下回っていた場合は、予約した時間から1時間以内であれば100%返金でのキャンセルが可能</p>
<div class="timeline-container hide-sm">
<div class="row clearfix">
<div class="col-sm-3 timeline-segment timeline-segment-refundable ">
        <div class="timeline-point">
          <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
            2週間前
          </div>

          <div class="timeline-point-marker"></div>
            <div class="timeline-point-label">
              12月2日（金）
              <br>9:00
            </div>
        </div>
      </div>
      
      <div class="col-sm-3 timeline-segment timeline-segment-partly-refundable">
      <div id="second-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          1週間前
        </div>
        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月9日（金）
            <br>9:00</div>
      </div>
    </div>
    
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          1週間未満前
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月9日（金）
            <br>9:01</div>
      </div>
    </div>
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          利用開始
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月16日（金）
            <br>9:00</div>
      </div>
    </div>
</div><!--/row-->
<div class="timeline-fineprint">例</div>
</div>
</div>
</div><!--/mgb-30-->
<div class="mgb-30">
<h4>月毎タイプの利用予約の場合</h4>
<div class="help_body_content">
<p>週毎利用タイプは、以下のキャンセル条件となります。</p>
<ol class="list-type-dot big-txt">
<li>利用開始日<strong>1ヶ月前</strong>までのキャンセルは<strong>100%返金</strong></li>
<li>利用開始日<strong>3週間前</strong>までのキャンセルは<strong>50%返金</strong></li>
<li>利用開始時間<strong>3週間未満前</strong>までのキャンセルは<strong>返金不可</strong></li>
</ol>
<p class="strong-notice">※但し、予約した時点で、予約開始日時までの時間が3週間を下回っていた場合は、予約した時間から1時間以内であれば100%返金でのキャンセルが可能</p>
<div class="timeline-container hide-sm">
<div class="row clearfix">
<div class="col-sm-3 timeline-segment timeline-segment-refundable ">
        <div class="timeline-point">
          <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
            2週間前
          </div>

          <div class="timeline-point-marker"></div>
            <div class="timeline-point-label">
              12月2日（金）
              <br>9:00
            </div>
        </div>
      </div>
      
      <div class="col-sm-3 timeline-segment timeline-segment-partly-refundable">
      <div id="second-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          1週間前
        </div>
        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月9日（金）
            <br>9:00</div>
      </div>
    </div>
    
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          1週間未満前
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月9日（金）
            <br>9:01</div>
      </div>
    </div>
    <div class="col-sm-3 timeline-segment timeline-segment-nonrefundable">
      <div id="third-point" class="timeline-point">
        <div class="tooltip tooltip-bottom-middle dark-caret-bottom-middle timeline-point-tooltip">
          利用開始
        </div>

        <div class="timeline-point-marker"></div>
          <div class="timeline-point-label">12月16日（金）
            <br>9:00</div>
      </div>
    </div>
</div><!--/row-->
<div class="timeline-fineprint">例</div>
</div>
</div>
</div><!--/mgb-30-->
</div>
</div><!--/container-->
</section>
</div><!--/hometop-->
<!--footer-->
<?php //include( $_SERVER['DOCUMENT_ROOT'] . '/design/common_footer.php'); ?>
		@include('pages.common_footer')

<!--/footer-->

</div><!--/viewport-->
</body>
</html>
