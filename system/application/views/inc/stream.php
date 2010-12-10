<?php foreach ($checkins as $id => $checkin): ?>

	<div row="<?=++$id?>" checkin_id="<?=$checkin['id']?>" class="item checkin <?=$checkin['source']?>" <?php if($checkin['message']):?>title="<?=$checkin['message']?>"<?php endif;?>> <!-- Tweet -->
		<img class="avatar" src="<?=$checkin['img']?>" />
		<span class="source <?=$checkin['source']?>"></span>
		<p class="person"><?=$checkin['person']?></p>
		<p id="place_<?=$checkin['place_id']?>" class="place"><?=$checkin['place_name']?></p>
		<p class="time"><?=$checkin['time']?> <span class="via">via <?=ucfirst($checkin['source'])?></span></p>
		<lat><?=$checkin['cords'][0]?></lat>
		<lon><?=$checkin['cords'][1]?></lon>
	</div>
	
	<?php if ($id=="2"): ?>
		<div class="item ad">
			<a href="http://hi.spncr.me/#contact" target="_blank"><div class="image"></div></a>
			<div class="text">
				<h4>Want to advertise?</h4>
				<p><a href="http://hi.spncr.me/#contact" target="_blank">Contact me</a> if you want more information on how to be the exclusive advertiser for Friends on a Map.</p>
			</div>
			<div class="clear"></div>
		</div>
	<?php endif;?>
	
<?php endforeach; ?>