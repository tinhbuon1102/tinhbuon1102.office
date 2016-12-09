<div class="financial-dash-section">
	@if(session()->has('success'))
			<div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ session()->get('success') }}
        	</div>
	@endif
	<table id="income_finance" class="dataTable table">
		<thead>
			<tr>
				<th width="10%" class="ns_border-lnone ns_border-rnone sorting_disabled" style="width: 11%;">日付</th>
				<th width="30%" class="ns_border-lnone ns_border-rnone sorting_disabled ns_align-l align-l" style="width: 100px;">会社名</th>
				<th width="50%" class="ns_border-lnone ns_border-rnone sorting_disabled ns_align-l align-l" style="width: 100px;">ファイル</th>
				<th width="10%" class="ns_border-lnone ns_border-rnone sorting_disabled ns_align-l align-l" style="width: 150px;">アクション</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($user->certificates as $indexCer => $certificate) {?>
			<tr class="<?php echo $indexCer % 2 == 0 ? 'even' : 'odd'?> incoming" type="fixed">
				<td>{{renderJapaneseDate($certificate->updated_at, false)}}</td>
				<td>{{$user->NameOfCompany}}</td>
				<td class="file_content">
					<a target="_blank" href="{{url('/'). $certificate->Path}}">{{url('/'). $certificate->Path}}</a>
				</td>
				<td class="ns_align-l align-l">
					<div class="invoice-view-bt action-wrapper ns_action-wrap btn-group">
						<a class="btn btn-mini btn-mini delete-certificate" href="{{url('/')}}/MyAdmin/ShareUser/{{$user->HashCode}}/Certificate?remove={{$certificate->id}}#tab-5" >削除</a>
					</div>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<div class="approve-buton">
		<form id="approve_form" action="{{url('MyAdmin/ShareUser/'. $user->HashCode . '/Certificate')}}" method="get">
			<input type="hidden" name="<?php echo ($user->IsAdminApproved == 'No') ? 'approve' : 'unapprove'?>" value="{{$user->id}}" />
			<input type="hidden" name="hash" value="#tab-5"/>
			<button id="approveButton" class="btn btn-info submitSettingsBtn" type="submit">
				<?php echo ($user->IsAdminApproved == 'No') ? '承認する' : '非承認'?>
			</button>
		</form>
	</div>
</div>

<!-- /.row -->
<script type="text/javascript">
	jQuery(function($){
		$('body').on('click', '.delete-certificate', function(e){
			var certificate = $(this);
			e.preventDefault();
			if (confirm('Are you sure you want to delete this certificate ?')) {
				$.ajax({
					url: certificate.attr('href'),
					method: 'get',
					success: function(response){
						if (response.success)
						{
							certificate.closest('tr').fadeOut(function(){
								$(this).remove();
							});
						}
					}
				})
			}
		});
	})
</script>