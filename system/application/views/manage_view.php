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

	<ul class="login">
		<li class="facebook">
			<img class="icon" src="<?=base_url()?>public/img/icons/social/facebook.png" alt="icon" />
			<?php if ($is_loggedin['facebook'][0]): ?>
			<span class="text">Logged in as <?=$is_loggedin['facebook'][1]?></span>
			<a href="<?=base_url()?>auth/logout/facebook/manage" class="logout">Logout</a>
			<?php else: ?>
			<span class="text">Facebook Places</span>
			<a href="<?=base_url()?>auth/login/facebook/manage" class="login">Login</a>
			<?php endif; ?>
			<div class="clear"></div>
		</li>
		<li class="foursquare">
			<img class="icon" src="<?=base_url()?>public/img/icons/social/foursquare.png" alt="icon" />
			<?php if ($is_loggedin['foursquare'][0]): ?>
			<span class="text">Logged into Foursquare</span>
			<a href="<?=base_url()?>auth/logout/foursquare/manage" class="logout">Logout</a>
			<?php else: ?>
			<span class="text">Foursquare</span>
			<a href="#" class="login">Login</a>
			<?php endif; ?>
			<div class="clear"></div>
	
			<?php if (!$is_loggedin['foursquare'][0]): ?>
			<form class="foursquare login_form" name="foursquare_login" action="<?=base_url()?>auth/login/foursquare/manage" method="post">
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
			<a href="<?=base_url()?>auth/logout/gowalla/manage" class="logout">Logout</a>
			<?php else: ?>
			<span class="text">Gowalla</span>
			<a href="#" class="login">Login</a>
			<?php endif; ?>
			<div class="clear"></div>
	
			<?php if (!$is_loggedin['gowalla'][0]): ?>
			<form class="gowalla login_form" name="gowalla_login" action="<?=base_url()?>auth/login/gowalla/manage" method="post">
				<input name="user" type="text" value="username" onfocus="this.value=''" />
				<input name="password" type="password"/>
				<input type="submit"/>
			</form>
			<?php endif; ?>
		</li>
	</ul>

</body>
</html>