<div class="help_header">
<h1>予約の確認方法</h1>
</div>
<h4>1.予約一覧ページを開く</h4>
<div class="help_body_content">
<p>ログイン後、メニューから<strong>[予約リスト]</strong>をクリック、または左メニューから<strong>[予約]</strong>をクリックしてください。</p>
<div class="help-shot"><img src="/images/help/booking/share/1.jpg" /></div>
</div>
<a id="spaceinfo"></a>
<h4>2.予約一覧の確認</h4>
<div class="help_body_content">
<p>一覧にて予約概要がわかる各項目が表示されます。</p>

<ol class="list-type-alp row">
<li class="col-md-4"><p><strong>予約番号(#)</strong><br/>
予約番号。</p></li>
<li class="col-md-4"><p><strong>顧客名</strong><br/>
予約をした顧客名。</p></li>
<li class="col-md-4"><p><strong>スペース名</strong><br/>
予約のスペース名。</p></li>
<li class="col-md-4"><p><strong>予約日</strong><br/>
予約が行われた日。</p></li>
<li class="col-md-4"><p><strong>利用開始日</strong><br/>
予約された利用開始日。</p></li>
<li class="col-md-4"><p><strong>期間</strong><br/>
予約された利用期間。</p></li>
<li class="col-md-4"><p><strong>合計金額</strong><br/>
予約されたスペース利用料金合計金額。</p></li>
<li class="col-md-4"><p><strong>支払金額</strong><br/>
予約時に支払われた金額。</p></li>
<li class="col-md-4"><p><strong>支払状況</strong><br/>
現在の支払状況。</p></li>
<li class="col-md-4"><p><strong>予約状況</strong><br/>
現在の予約状況。</p></li>
<li class="col-md-4"><p><strong>アクション</strong><br/>
予約詳細を見るためのリンク。</p></li>
</ol>

<div class="help-shot mgb-30"><img src="/images/help/booking/share/2.jpg" /></div>
<a id="bookingstatus"></a>
<p><strong><i class="fa fa-info-circle" aria-hidden="true"></i>予約状況について</strong><br/>
予約状況には以下の種類があります。</p>
<ol class="list-style-bookstatus mgb-30">
<li><p class="btn btn-pending-alt btn-xs">処理中</p><p class="mgt-0">予約受付待ちの予約です。処理中の場合、決済はまだ処理されていない状況です。</p></li>
<li><p class="btn btn-reserved-alt btn-xs">予約済み</p><p class="mgt-0">予約受付済みの予約です。予約済みの場合、決済は完了している状況です。</p></li>
<li><p class="btn btn-inuse-alt btn-xs">利用中</p><p class="mgt-0">現在時刻で利用中の予約です。利用中の場合、キャンセルはできません。</p></li>
<li><p class="btn btn-success-alt btn-xs">完了</p><p class="mgt-0">利用が終了している予約です。完了の場合、キャンセルはできません。</p></li>
<li><p class="btn btn-cancel-alt btn-xs">キャンセル</p><p class="mgt-0">キャンセルされた予約です。一度キャンセルされた予約は変更できません。</p></li>
</ol>

<a id="paymentstatus"></a>
<p><strong><i class="fa fa-info-circle" aria-hidden="true"></i>支払状況について</strong><br/>
支払状況には以下の種類があります。</p>
<ol class="list-style-bookstatus">
<li><p class="btn btn-presale-alt btn-xs">仮売上</p><p class="mgt-0">決済がまだ処理されていない予約です。予約が入った時点で、全てこのステータスとなります。</p></li>
<li><p class="btn btn-realsale-alt btn-xs">本売上</p><p class="mgt-0">決済が完了した予約です。</p></li>
<li><p class="btn btn-refund-alt btn-xs">返金済</p><p class="mgt-0">決済金額を返金した予約です。一度返金したら、返金の取り消しはできません。</p></li>
<li><p class="btn btn-refund-alt btn-xs">返金不可</p><p class="mgt-0">キャンセルされたが、<a href="{{url('cancel-policy')}}" class="color-link" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>キャンセルポリシー</a>に基づき、返金がされなかった予約です。</p></li>
</ol>
</div>

<h4>3.予約詳細の確認</h4>
<div class="help_body_content">
<p>アクションの欄から<strong>[詳細]</strong>ボタンをクリックし、予約詳細ページを確認してください。</p>
<div class="help-shot"><img src="/images/help/booking/share/5.jpg" /></div>
<p>予約詳細ページは以下の様に予約内容が表示されます。</p>
<ol class="list-type-alp mgb-0 row">
<li class="col-md-4"><strong>[予約基本情報]</strong>
<ul class="detail-list">
<li><strong>予約受付日</strong><br/>予約された日時</li>
<li><strong>ステータス</strong><br/>予約状況</li>
<li><strong>キャンセル可能日</strong><br/>この日時まで100%返金キャンセル可能</li>
</ul>
</li>
<li class="col-md-4"><strong>[予約詳細]</strong>
<ul class="detail-list">
<li><strong>利用日</strong><br/>予約された利用日</li>
<li><strong>スペース名</strong><br/>予約されたスペース名</li>
<li><strong>スペースタイプ</strong><br/>予約されたスペースタイプ</li>
<li><strong>利用人数</strong><br/>予約者の利用人数</li>
<li><strong>備考</strong><br/>予約者が書いた備考</li>
</ul>
</li>
<li class="col-md-4"><strong>[予約者情報]</strong>
<ul class="detail-list">
<li><strong>会社名</strong><br/>予約者の会社名<br/>※会社でない場合はここは表示されません</li>
<li><strong>氏名</strong><br/>予約者の氏名</li>
<li><strong>住所</strong><br/>予約社の住所</li>
<li><strong>チャット</strong><br/>予約者とメッセージのやりとりがしたい場合は、このボタンをクリックするとメッセージが送れます。</li>
</ul>
</li>
<li class="col-md-4 clear"><strong>[予約メモ]</strong>
<ul class="detail-list no-disc">
<li>予約ステータス、支払ステータスが更新されると、更新履歴が表示されます。</li>
</ul>
</li>
<li class="col-md-4"><strong>[合計金額]</strong>
<ul class="detail-list no-disc">
<li>予約の利用合計金額と内訳が表示されます。</li>
</ul>
</li>
<li class="col-md-4"><strong>[支払情報]</strong>
<ul class="detail-list">
<li><strong>支払状況</strong><br/>現在の支払ステータス</li>
<li><strong>決済方法</strong><br/>この予約の決済方法</li>
<li><strong>トランザクションID</strong><br/>支払取引の情報を管理するID</li>
<li><strong>支払日</strong><br/>決済がされた日</li>
</ul>
</li>
</ol>

<div class="help-shot"><img src="/images/help/booking/share/3.jpg" /></div>
<div class="help-shot"><img src="/images/help/booking/share/4.jpg" /></div>
</div>

