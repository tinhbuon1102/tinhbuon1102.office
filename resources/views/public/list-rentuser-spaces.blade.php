<style>
.space-list-item {
	clear: both;
}

.space-list-item-content {
	border-bottom: 1px solid #E0E0E0;
    padding: 10px 0;
    overflow: hidden;
}
.space-list-item img {
	max-width: 90px;
}
.space-list-item .col3 {
	text-align: right;
}

</style>
<?php 
if (!empty($spaces)) {
echo '<ul class="space-list-wraper">';
?>
<!--<li class="space-list-item">
	<div class="col-sm-4 col1"><?//=trans("common.Image")?></div>
	<div class="col-sm-4 col2"><?//=trans("common.Title")?></div>
	<div class="col-sm-4 col3">&nbsp;</div>
</li>-->
<?php
foreach ($spaces as $space) {
	$offered = false;
?>
	<li class="space-list-item space-list-item-content">
    <div class="row dis-table-wrapper">
		<div class="col-sm-2 thum">
		<?php if ($space->spaceImage && isset($space->spaceImage[0]) && $space->spaceImage[0]['ThumbPath']) {?>
			<img src="<?php echo $space->spaceImage[0]['ThumbPath']?>"/>
		<?php }?></div>
		<div class="col-sm-8 disc"><?php echo $space->Title?></div>
		
			<?php if ($space->notification && count($space->notification)) {
				foreach ($space->notification as $notification)
				{
					if ($notification['UserSendID'] == $request->userSendId && $notification['UserSendType'] == 1 && $notification['UserReceiveID'] == $request->userReceiveId && $notification['UserReceiveType'] == 2)
					{
						$offered = true;
						break;
					}
				}
			}?>
			<?php if ($offered) {?>
            
            
            <div class="col-sm-2 offer-btn-wrap">
				<span class="btn offerd-label offered offer_btn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i><?=trans("common.Offered")?></span>
                </div>
                
			<?php }else {?>
            <div class="col-sm-2 offer-check-wrap">
				<input type="checkbox" name="space_id[]" value="<?php echo $space->id?>"/>
                </div>
			<?php }?>
		</div>
        
	</li>
<?php }
?>
<?php
echo '</ul>';
}?>
<div id="offer-submit-foot">
<div class="row">
	<div class="col-sm-12 offer-submit"><input name="submit" class="btn btn-info" value="オファーを送る" type="submit" id="space_list_submit"/></div>
</div>
</div>


