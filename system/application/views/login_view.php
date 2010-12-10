<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Friends on a Map</title>
		
	<?php $this->carabiner->display('js'); ?>
	<?php $this->carabiner->display('css'); ?>
	
</head>

<?php if ($this->session->flashdata('state_change') == TRUE): ?>
	<body onload="window.parent.location.reload();">
<?php else:?>
	<body>
<?php endif;?>
	
	<div id="page">
		<div class="header">
			<h1>Friends On A Map</h1>
			<h2>All your friends checkins on one map</h2>
		</div>
		
		<?php //print_r($is_loggedin) ?>
		
		<ul class="login home">
			<li class="facebook">
				<img class="icon" src="<?=base_url()?>public/img/icons/social/facebook.png" alt="icon" />
				<?php if ($is_loggedin['facebook'][0]): ?>
				<span class="text">Logged in as <?=$is_loggedin['facebook'][1]?></span>
				<a href="<?=base_url()?>auth/logout/facebook" class="logout">Logout</a>
				<?php else: ?>
				<span class="text">Facebook Places</span>
				<a href="<?=base_url()?>auth/login/facebook" class="login">Login</a>
				<?php endif; ?>
				<div class="clear"></div>
			</li>
			<li class="foursquare">
				<img class="icon" src="<?=base_url()?>public/img/icons/social/foursquare.png" alt="icon" />
				<?php if ($is_loggedin['foursquare'][0]): ?>
				<span class="text">Logged into Foursquare</span>
				<a href="<?=base_url()?>auth/logout/foursquare" class="logout">Logout</a>
				<?php else: ?>
				<span class="text">Foursquare</span>
				<a href="#" class="login">Login</a>
				<?php endif; ?>
				<div class="clear"></div>
				
				<?php if (!$is_loggedin['foursquare'][0]): ?>
				<form class="foursquare login_form" name="foursquare_login" action="<?=base_url()?>auth/login/foursquare" method="post">
					<input name="user" type="text" value="email" onfocus="this.value=''" />
					<input name="password" type="password"/>
					<input type="submit"/>
				</form>
				<?php endif;?>
			</li>
			<li class="gowalla">
				<img class="icon" src="<?=base_url()?>public/img/icons/social/gowalla.png" alt="icon" />
				<?php if ($is_loggedin['gowalla'][0]): ?>
				<span class="text">Logged into Gowalla</span>
				<a href="<?=base_url()?>auth/logout/gowalla" class="logout">Logout</a>
				<?php else: ?>
				<span class="text">Gowalla</span>
				<a href="#" class="login">Login</a>
				<?php endif; ?>
				<div class="clear"></div>
				
				<?php if (!$is_loggedin['gowalla'][0]): ?>
				<form class="gowalla login_form" name="gowalla_login" action="<?=base_url()?>auth/login/gowalla" method="post">
					<input name="user" type="text" value="username" onfocus="this.value=''" />
					<input name="password" type="password"/>
					<input type="submit"/>
				</form>
				<?php endif; ?>
			</li>
		</ul>
		
		<!--<img class="screenshot" src="<?=base_url()?>public/img/screenshots/browser.png" alt="browser screenshot">-->
				
		<div class="item ad">
			<a href="http://hi.spncr.me/#contact" target="_blank"><div class="image"></div></a>
			<div class="text">
				<h4>Want to advertise?</h4>
				<p><a href="http://hi.spncr.me/#contact" target="_blank">Contact me</a> if you want more information on how to be the exclusive advertiser for Friends on a Map.</p>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="share">
		
			<div class="facebook">
				<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D121539294561851&amp;layout=button_count&amp;show_faces=false&amp;width=10&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
			</div>
		
			<div class="twitter">
				<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://friendsonamap.com" data-text="Check out Friends on a Map — a cool way to visualize your friends checkins" data-count="horizontal" data-via="netspencer" data-related="pitch_ly">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			</div>
				
		</div>
		
		<div style="clear:both;"></div>
		
		
		<div class="footer">Created by <a href="http://spncr.me">Spencer Schoeben</a></div>
		
	</div>
	
</body>
</html>
