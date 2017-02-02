<section class="feed-event recent-follow feed-box" id="payinfo">
	<div class="dashboard-section-heading-container">
		<h3 class="dashboard-section-heading">
			支払受取情報
			<!--15%-->
			<!--Payment Info-->
		</h3>
		<a class="toggle_button edit" bind-toggle=".bank-account-edit-container, .saved-bank-account" href="#"><i class="fa fa-pencil" aria-hidden="true"></i>編集</a>
	</div>
	<form id="bank-account" class="fl-form" method="post" action="{{url('ShareUser/Dashboard/HostSetting/BankInfo')}}">
		<div class="space-setting-content">
			<div class="saved-bank-account">
				<div class="saved-value">
					<label>
						口座の種類
						<!--Account Type-->
						:
					</label>
					<span id="spanAccountType">{{$bank->AccountType}}</span>
				</div>
				<div class="saved-value">
					<label>
						名義
						<!--Account Name-->
						:
					</label>
					<span id="spanAccountName">{{$bank->AccountName}}</span>
				</div>
				<div class="saved-value">
					<label>
						銀行名
						<!--Bank Name-->
						:
					</label>
					<span id="spanBankName">{{$bank->BankName}}</span>
				</div>
				<div class="saved-value">
					<label>
						支店名
						<!--Branch location name-->
						:
					</label>
					<span id="spanBranchLocationName">{{$bank->BranchLocationName}}</span>
				</div>
				<div class="saved-value">
					<label>
						口座番号
						<!--Account Number-->
						:
					</label>
					<span id="spanAccountNumber">{{$bank->AccountNumber}}</span>
				</div>
			</div>
			<!--/saved-bank-account-->
			<!--show here if you click edit-->
			<div class="bank-account-edit-container" style="display: none;">
				<div class="form-container">
					<div class="form-field">
						<div id="account-type-radio" class="input-container input-half">
							<label for="AccountType">
								<span class="require-mark">*</span>
								口座の種類
								<!--Account Type-->
							</label>
							<div class="radio inline">
								<input type="radio" name="AccountType" id="checking" value="当座預金" aria-hidden="true" <? if($bank->AccountType=="当座預金"){ ?> checked <? } ?>>
								<label for="checking">当座預金</label>
							</div>
							<!--/radio inline-->
							<div class="radio inline">
								<input type="radio" name="AccountType" id="savings" value="普通預金" aria-hidden="true" @if($bank->AccountType=="普通預金") checked @endif>
								<label for="savings">普通預金</label>
							</div>
							<!--/radio inline-->
						</div>
					</div>
					<!--/form-field-->
					<div class="form-field">
						<div class="input-container input-half">
							<label for="AccountName">
								<span class="require-mark">*</span>
								名義
								<!--Account Name-->
							</label>
							<input id="nativeName" name="AccountName" type="text" class="hasHelp js_needsValidation validate[required,custom[zengin]]" value="{{$bank->AccountName}}" placeholder="カ）アワーオフィス" autocomplete="off">
							<!-- pattern="[\u30A0-\u30FF \s]*" aria-invalid="false" -->
						</div>

						<div class="input-container input-half">
							<label for="accountNumber">
								<span class="require-mark">*</span>
								口座番号
								<!--Account Number-->
							</label>
							<input id="accountNumber" name="AccountNumber" type="text" class="hasHelp js_needsValidation validate cobrowse_mask validate[required]" value="{{$bank->AccountNumber}}" placeholder="口座番号" autocomplete="off" maxlength="7">
							<!--pattern="[0-9]{7}"-->
						</div>
					</div>

					<!--/form-field-->
					<div class="form-field">
						<div class="input-container input-half">
							<label for="BankName">
								<span class="require-mark">*</span>
								金融機関コード
								<!--Bank code-->
							</label>
							<input id="bank-code" name="BankCode" type="text" class="hasHelp js_needsValidation validate validate[groupRequired[codes]]" value="{{$bank->BankCode}}" autocomplete="off" placeholder="0000" max="9999" maxlength="4" min="0">
							<!--pattern="[0-9]{4}" -->
						</div>
						<div class="input-container input-half">
							<label for="BankName">
								銀行名 (銀行コードに基づいてオートコンプリート)
								<!--Bank Name-->
							</label>
							<input id="bank-name" name="BankName" type="text" class="hasHelp disabled-input-background" readonly="readonly" value="{{$bank->BankName}}" placeholder="" autocomplete="off" maxlength="64">
						</div>
					</div>

					<!--/form-field-->
					<div class="form-field {!! ($bank->BranchCode) ? "" : 'hide' !!} bank-branch-data-wrapper">
						<div class="input-container input-half">
							<label for="BankName">
								<span class="require-mark">*</span>
								支店コード
								<!--支店コード-->
							</label>
							<input id="branch-code" name="BranchCode" type="text" class="hasHelp js_needsValidation validate[groupRequired[codes]]" value="{{$bank->BranchCode}}" autocomplete="off" placeholder="000" maxlength="3" min="0" max="999">
							<!--pattern="[0-9]{3}" -->
						</div>


						<div class="input-container input-half">
							<label for="BankName">
								支店名 (支店コードに基づいてオートコンプリート)
								<!--Branch location name-->
							</label>
							<input id="branch-name" name="BranchLocationName" type="text" class="hasHelp disabled-input-background" readonly="readonly" value="{{$bank->BranchLocationName}}" placeholder="支店名" autocomplete="off" aria-invalid="false">
							<!--pattern=".*"-->
						</div>

					</div>

					<!--/form-field-->
					<div class="btn-wrapper">
						{{ csrf_field() }}
						<button type="submit" class="upload-button btn ui-button-text-only yellow-button" role="button">
							<span class="ui-button-text">保存</span>
						</button>
						<button class="toggle_button cancel-button btn ui-button-text-only" role="button" bind-toggle=".bank-account-edit-container, .saved-bank-account">
							<span class="ui-button-text cancel">キャンセル</span>
						</button>
					</div>
				</div>
				<!--/form-container-->
			</div>
			<!--/bank-account-edit-container-->
			<!--/show here if you click edit-->
		</div>
		<!--/space-setting-content-->
	</form>
</section>

