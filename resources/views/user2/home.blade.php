@extends('user2Layout')
@section('title')
	Offispo | オフィスポ
@stop
@section('content')
<body class="rentuser">
<div class="viewport">
<section class="hero anim active">
<div class="hero-animation">
<div class="nav">
<div class="logo_container"><a class="logo" href="{{ url('/') }}"></a></div>
</div>
<div class="hero-copy">
<div class="invert-copy">
<h1>WORK AT ANY OFFICE YOU LIKE</h1>
<p>好きなオフィスで自由に働こう</p>
<a class="button yellow_btn" data-link-action="Sign Up" data-link-label="Hero Section" href="{{ url('Register-RentUser') }}">先行会員登録</a>
</div>
</div>
<video autoplay loop width="100%" poster="{{ URL::asset('lpnew/rentuser/images/offispot_video_image.jpg') }}">
<source src="offispot_animation_movie.mp4" type="video/mp4">Your browser does not support the video tag. I suggest you upgrade your browser.
</video>
</div>
</section>
<section id="content">
<section class="one">
    <div class="left">
        <div class="content">
        
<h2>好きな場所で<br/>あなたのオフィスを見つけよう</h2>
            <p>期間にとらわれず低コストでオフィスを利用したい。<br/>日本どこでも自由にオフィスが利用したい。<br/>
そんなスタートアップオフィスをお探しの企業やワークスペースをお探しの個人事業の方へ。<br/>
オフィスポはあなたにぴったりのワークスペース探しをお手伝い致します。<br/>
フリーデスクから会議室、プライベートオフィスまで、様々な種類のオフィスが見つかります。<br/>
もちろん、敷金、礼金、年単位での契約期間も無く、ワンクリックで、<br/>すぐにあなたのワークスペースが見つかります。
            </p>
            <p class="notice">※利用するにはシェアする側の審査があり、承認後利用可能となります。</p>
        </div>
       
    </div>
    <div class="right" title=""><div class="sec1_img"><img src="{{ URL::asset('lpnew/rentuser/images/img_sec01.png') }}" /></div></div>
</section>
<section class="two">
    <div class="right" title=""></div>
    <div class="left">
        <div class="content">
            <h2>オフィス探し×ビジネスチャンス</h2>
            <p>
オフィスポは、地域や広さのニーズはもちろんですが、<br/>
業種ごとに検索ができ、一緒に働く人を選べたり、気になるあの会社のオフィスで働く事も可能。<br/>
さらに、あなたのプロフィールページをシェアする側の企業から閲覧できるので、企業側からのオファーもゲットできます。<br/>
ワークスペースの確保だけではなく、ビジネスシーンでのチャンス、ステップアップも見つかるかもしれません。
            </p>
            
        </div>
    </div>
</section>
<section class="three">
<h2>オフィスポの特徴</h2>
<div class="section_clear container">
<div class="services-grid fst clear">
<div class="services-list"><div class="icon_wrapper"><span class="icon-offispo-icon-07"></span></div><h4>月、週、日毎に利用できるオフィス</h4><p>一日毎、一月だけ使いたい！<br>
など、短期間でも利用可能。</p></div>
<div class="services-list"><div class="icon_wrapper"><span class="icon-offispo-icon-06"></span></div><h4>直接やりとりができる</h4><p>直接細かいことを聞きたいなど、<br>
柔軟にやりとりができるダイレクトメール。</p></div>
<div class="services-list last"><div class="icon_wrapper"><span class="icon-icon-network"></span></div><h4>業種に特化したネットワーク</h4><p>業界や事業内容が記載されているので
<br>気になる業種のオフィスで働ける。</p></div>
</div>
<div class="services-grid last clear">
<div class="services-list"><div class="icon_wrapper"><span class="icon-offispo-icon-08"></span></div><h4>シンプルな利用規約</h4><p>煩わしい契約書は無く、<br>
シェア期間が選択可能。</p></div>
<div class="services-list"><div class="icon_wrapper"><span class="icon-offispo-icon-05"></span></div><h4>クレジットカードにて簡単決済</h4><p>クレジットカード引き落としだから、
<br>支払い忘れも無く、簡単決済。</p></div>
<div class="services-list last"><div class="icon_wrapper"><span class="icon-icons-desktop"></span></div><h4>一度の登録でいつでも利用可能</h4><p>登録後は、様々なオフィスが
<br>いつでもすぐに利用可能。</p></div>
</div>
</div>
</section>
<section class="four">
    <div class="left">
        <div class="content">
            <div class="how"><h2>あなたのプロフィールを作成</h2>
            <p>
オフィスを提供する企業があなたのプロフィールを閲覧できます。<br>
企業側にとって魅力的なプロフィールページを作りましょう。
            </p>
            <ul>
<li><i class="icon-icon-user"></i>基本情報</li>
<li><i class="icon-icon-tie"></i>あなたの業種</li>
<li><i class="icon-icon-heart"></i>オフィスの希望職種</li>
<li><i class="icon-offispo-icon-08"></i>オフィスの希望条件</li>
<li>...etc</li>
</ul></div>
<span>01</span>
        </div>
       
    </div>
    <div class="right" title=""></div>
</section>
<section class="five">
    <div class="left" title=""></div>
    <div class="right">
        <div class="content">
            <div class="how"><h2>あなたの希望条件に<br/>マッチしたオフィスを選ぼう</h2>
            <p>
地域、収容人数、業種などの詳細な検索条件から、<br/>あなたにぴったりのオフィスを選びましょう。
            </p>
            <ul>
<li><i class="icon-icon-search"></i>あなたに合うオフィスを条件検索</li>
<li><i class="icon-icon-heartplus"></i>気になるオフィスはお気に入りで保存</li>
<li><i class="icon-icon-chat"></i>提供する企業とチャットで直接連絡が可能</li>
</ul>
            </div>
            <span>02</span>
        </div>
    </div>
</section>
<section class="six">
    <div class="left">
        <div class="content">
            <div class="how"><h2>クリックで簡単予約。<br/>面倒なことや賃貸契約はありません。</h2>
            <p>
条件に合うオフィススペースが見つかったら、”予約する”をクリック。<br>
書面での契約などはいらず、簡単に予約ができます。
            </p>
            <ul>
<li><i class="icon-icon-block"></i>長期契約に縛られない</li>
<li><i class="icon-offispo-icon-07"></i>日、週、月毎で利用できる</li>
<li><i class="icon-offispo-icon-05"></i>カード決済で簡単支払い</li>
</ul>
            </div>
            <span>03</span>
        </div>
       
    </div>
    <div class="right" title=""></div>
</section>
<section class="seven">
<div class="container">
<h3>SPACES FOR ANY STAGE</h3>
<p class="subt">様々な用途に合わせたワークスペースが見つかる</p>
<div class="grid_circle clear">
<div class="grid_circle_list"><div class="circle-list"><figure class="circle_img"><img src="{{ URL::asset('lpnew/rentuser/images/circle1.jpg') }}" /></figure><p>会議室</p></div></div>
<div class="grid_circle_list"><div class="circle-list"><figure class="circle_img"><img src="{{ URL::asset('lpnew/rentuser/images/circle2.jpg') }}" /></figure><p>スモールスペース・デスク</p></div></div>
<div class="grid_circle_list"><div class="circle-list"><figure class="circle_img"><img src="{{ URL::asset('lpnew/rentuser/images/circle3.jpg') }}" /></figure><p>プライベートオフィス</p></div></div>
</div>
</div>
</section>
<section class="nine">
<div class="container">
<h3>Get start now!</h3>
<p class="subt">さぁ、いますぐ先行登録しよう</p>
<a class="button yellow_btn" data-link-action="Sign Up" data-link-label="Hero Section" href="{{ url('Register-RentUser') }}">先行会員登録</a>
</div>
</section>
</section><!--/#content-->
<section class="ten">
<div class="container">
<h3 class="ja">シェアスペースを<br class="pc-none">お持ちですか？</h3>
<p class="subt">余っているスペースを、臨時収入と新しい出会いに変えましょう</p>
<a class="button yellow_btn" href="{{ url('/') }}">シェアスペース提供を<br class="pc-none">ご検討の方はコチラ</a>
</div>
</section><!--/#content-->
<footer>
<div class="footer">
<div class="f-logo">
<img src="{{ URL::asset('lpnew/rentuser/images/logo-wht.png') }}" />
<p class="copy">&copy;2016 AVENTURES INC.</p>
</div><!--/f-logo-->
<div class="middle-link"><a class="company-link ja" href="http://office-spot.com/lp/public/company">運営会社</a>|<a class="contact-btn" href="http://office-spot.com/lp/public/contact">お問い合わせ</a></div>
<div class="social">
<a href="https://twitter.com/_9337943632122" target="_blank" class="icon-sns-icon-twi"></a>
<a href="https://www.facebook.com/Japanproperties/?ref=tn_tnmn" target="_blank" class="icon-sns-icon-fb"></a>
<a href="#" target="_blank" class="icon-icon-newinsta"></a>
</div><!--/social-->
</div>
</footer>
</div><!--/viewport-->
</body>
@stop