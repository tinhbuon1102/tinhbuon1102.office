
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
<h1 class="hero-article-title"><strong>クッキーポリシー</strong></h1>
</div>
<div class="parallax-container"></div>
</div>

<div class="home-top">
<section id="howitwork" class="white">
<div class="container">
<div class="pp-content">
<ol>
	<li>
	<p>個人情報の定義</p>

	<p>株式会社アベンチャーズは、個人情報とは、個人情報の保護に関する法律に規定される生存する個人に関する情報（氏名、生年月日、その他の特定の個人を識別することができる情報）、ならびに特定の個人と結びついて使用されるメールアドレス、ユーザーＩＤ、パスワード、クレジットカードなどの情報、および個人情報と一体となった趣味、家族構成、年齢その他の個人に関する属性情報であると認識しています。</p>
	</li>
	<li>
	<p>クッキー・IPアドレス情報</p>

	<p>クッキー及びＩＰアドレス情報については、それら単独では特定の個人を識別することができないため、個人情報とは考えておりません。ただしこれら情報と個人情報が一体となって使用される場合にはこれら情報も個人情報とみなします。株式会社アベンチャーズの運営するメディアにおいては、たとえ特定の個人を識別することができなくとも、クッキー及びＩＰアドレス情報を利用する場合には、その目的と方法を開示してまいります。また、クッキー情報については、ブラウザの設定で拒否することが可能です。クッキーを拒否するとサービスが受けられない場合は、その旨も公表します。</p>
	</li>
	<li>
	<p>個人情報利用目的の特定</p>

	<p>株式会社アベンチャーズは、個人情報を取り扱うにあたって、その利用の目的を出来る限り特定します。</p>
	</li>
	<li>
	<p>個人情報利用の制限</p>

	<p>株式会社アベンチャーズは、あらかじめご本人の同意を得ず、利用目的の達成に必要な範囲を超えて個人情報を取扱うことはありません。合併その他の理由に より個人情報を取得した場合にも、あらかじめご本人の同意を得ないで、承継前の利用目的の範囲を超えて取扱うことはありません。ただし、次の場合 はこの限りではありません。<br>
	（1）法令に基づく場合<br>
	（2）人の生命、身体または財産の保護のために必要がある場合であって、ご本人の同意を得ることが困難であるとき<br>
	（3）公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、ご本人の同意を得ることが困難であるとき<br>
	（4）国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、ご本人の同意を得るこ とにより当該事務の遂行に支障を及ぼすおそれがあるとき</p>
	</li>
	<li>
	<p>個人情報の適正な取得</p>

	<p>株式会社アベンチャーズは、適正に個人情報を取得し、偽りその他不正の手段により取得することはありません。</p>
	</li>
	<li>
	<p>個人情報の取得に際する利用目的の通知</p>

	<p>株式会社アベンチャーズは、個人情報を取得するにあたり、あらかじめその利用目的を公表します。ただし、次の場合はこの限りではありません。<br>
	（1）利用目的をご本人に通知し、または公表することによりご本人または第三者の生命、身体、財産その他の権利利益を害するおそれがある場合<br>
	（2）利用目的をご本人に通知し、または公表することにより株式会社アベンチャーズの権利または正当な利益を害するおそれがある場合<br>
	（3）国の機関もしくは地方公共団体が法令の定める事務を遂行することに対して協力する必要がある場合であって、利用目的をご本人に通知し、または公表することにより当該事務の遂行に支障を及ぼすおそれがあるとき<br>
	（4）取得の状況からみて利用目的が明らかであると認められる場合</p>
	</li>
	<li>
	<p>個人情報利用目的の変更</p>

	<p>株式会社アベンチャーズは、個人情報の利用目的を変更する場合には、変更前の利用目的と相当の関連性を有すると合理的に認められる範囲を超えては行わず、変更された利用目的について、ご本人に通知し、または公表します。</p>
	</li>
	<li>
	<p>個人情報の安全管理・従業員の監督</p>

	<p>株式会社アベンチャーズは、個人情報の漏洩、滅失またはき損の防止その他の個人情報の安全管理が図られるよう、情報セキュリティ基本方針および情報セキュリティポリシーを掲げ、情報セキュリティ委員会を設置し、従業員に対する必要かつ適切な監督を行います。 株式会社アベンチャーズは、従業員に個人情報を取り扱わせるにあたっては、個人情報の安全管理が図られるよう、従業員に対する必要かつ適切な監督を行います。</p>
	</li>
	<li>
	<p>委託先の監督</p>

	<p>株式会社アベンチャーズは、個人情報の取扱いの全部又は一部を委託する場合は、委託先と機密保持を含む契約の締結、または、株式会社アベンチャーズが定める約款に合意を求め、委託先において個人情報の安全管理が図られるよう、必要かつ適切な監督を行います。</p>
	</li>
	<li>
	<p>第三者提供の制限</p>

	<p>株式会社アベンチャーズは、次に掲げる場合を除くほか、あらかじめご本人の同意を得ないで、個人情報を第三者に提供しません。<br>
	（1）法令に基づく場合<br>
	（2）人の生命、身体または財産の保護のために必要がある場合であって、ご本人の同意を得ることが困難であるとき<br>
	（3）公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、ご本人の同意を得ることが困難であるとき<br>
	（4）国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、ご本人の同意を得ることにより当該事務の遂行に支障を及ぼすおそれがあるとき<br>
	（5）予め次の事項を告知あるいは公表をしている場合<br>
	　1. 予め次の事項を告知あるいは公表をしている場合<br>
	　2. 利用目的に第三者への提供を含むこと<br>
	　3. 第三者に提供されるデータの項目<br>
	　4. 第三者への提供の手段または方法<br>
	　5. ご本人の求めに応じて個人情報の第三者への提供を停止すること<br>
	ただし次に掲げる場合は上記に定める第三者には該当しません<br>
	（1）株式会社アベンチャーズが利用目的の達成に必要な範囲内において個人情報の取扱いの全部または一部を委託する場合<br>
	（2）合併その他の事由による事業の承継に伴って個人情報が提供される場合<br>
	（3）個人情報を特定の者との間で共同して利用する場合であって、その旨並びに共同して利用される個人情報の項目、共同して利用する者の範囲、利用する者の利用目的および当該個人情報の管理について責任を有する者の氏名または名称について、あらかじめご本人に通知し、またはご本人が容易に知り得る状態に置いているとき<br>
	株式会社アベンチャーズは、個人情報を特定の者との間で共同して利用する場合、利用目的または管理責任者の氏名または名称が変更される場合は、変更する内容について、あらかじめご本人に通知し、またはご本人が容易に知り得る状態に置きます。</p>
	</li>
	<li>
	<p>個人情報に関する事項の公表等</p>

	<p>株式会社アベンチャーズは、個人情報に関する次に掲げる事項について、ご本人の知り得る状態に置き、ご本人の求めに応じて遅滞なく回答します。<br>
	（1）個人情報の利用目的（ただし、個人情報の保護に関する法律において、その義務がないと規定されるものは除きます。ご回答しない決定をした場合は、ご本人に対して遅滞なくその旨を通知します。）<br>
	（2）個人情報に関するお問い合わせ窓口</p>
	</li>
	<li>
	<p>個人情報の開示</p>

	<p>株式会社アベンチャーズは、ご本人から、個人情報の開示を求められたときは、ご本人に対し、遅滞なく開示します。ただし、開示することにより次のいずれかに該当する場合は、その全部または一部を開示しないこともあり、開示しない決定をした場合には、その旨を遅滞なく通知します。<br>
	（1）ご本人または第三者の生命、身体、財産その他の権利利益を害するおそれがある場合<br>
	（2）株式会社アベンチャーズの業務の適正な実施に著しい支障を及ぼすおそれがある場合<br>
	（3）他の法令に違反することとなる場合<br>
	なお、アクセスログなどの個人情報以外の情報については、原則として開示いたしません。</p>
	</li>
	<li>
	<p>個人情報の訂正等</p>

	<p>株式会社アベンチャーズは、ご本人から、個人情報が真実でないという理由によって、内容の訂正、追加または削除（以下「訂正等」といいます）を求められた場合には、他の法令の規定により特別の手続きが定められている場合を除き、利用目的の達成に必要な範囲内において、遅滞なく必要な調査を行い、その結果に基づき、個人情報の内容の訂正等を行い、その旨ご本人に通知します。</p>
	</li>
	<li>
	<p>個人情報の利用停止等</p>

	<p>株式会社アベンチャーズは、ご本人から、ご本人の個人情報が、あらかじめ公表された利用目的の範囲を超えて取り扱われているという理由、または偽りその他不正の手段により取得されたものであるという理由により、その利用の停止または消去（以下「利用停止等」といいます）を求められた場合には、遅滞なく必要な調査を行い、その結果に基づき、個人情報の利用停止等を行い、その旨ご本人に通知します。ただし、個人情報の利用停止等に多額の費用を有する場合その他利用停止等を行うことが困難な場合であって、ご本人の権利利益を保護するために必要なこれに代わるべき措置をとれる場合は、この代替策を講じます。</p>
	</li>
	<li>
	<p>理由の説明</p>

	<p>株式会社アベンチャーズは、ご本人からの要求にもかかわらず、<br>
	（1）利用目的を通知しない<br>
	（2）個人情報の全部または一部を開示しない<br>
	（3）個人情報の利用停止等を行わない<br>
	（4）個人情報の第三者提供を停止しない<br>
	のいずれかを決定する場合、その旨ご本人に通知する際に理由を説明するよう努めます。</p>
	</li>
</ol>
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
