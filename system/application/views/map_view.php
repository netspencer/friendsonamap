<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<meta name="apple-mobile-web-app-capable" content="yes" />
				
	<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA0RyJy1wDdB7ma2sEwAul5hSg2lzRhBZSfX8n38HaaRvAknK_UBSBQ2m1f-zonbzrWNQW4BTOJutmhg"></script>
	<script type="text/javascript" charset="utf-8">
	    google.load("maps", "2.x");
	</script>
	
	<?php $this->carabiner->display('js'); ?>
	<?php $this->carabiner->display('css'); ?>
	
	<title>Friends on a Map</title>
	
</head>

<body>
	
	<div id="manage">
		<iframe src="http://friendsonamap.com/manage"></iframe>
	</div>
	
	<div id="header">
		<div class="content">
			<div class="streamController"> <!-- Stream Controller -->
				<span class="previous" onclick="streamController('previous')"></span>
				<span class="play" onclick="streamController('toggle')"></span>
				<span class="next" onclick="streamController('next')"></span>
			</div>
			<div class="welcome">Welcome <?=$user?> • <a class="manage" href="#">Manage</a> • <a href="<?=base_url()?>auth/logout">Logout</a></div>
		</div>
	</div>
	
	<div id="map"></div>
	
	<div id="stream">
	
	<?php $this->load->view('inc/stream', array('checkins' => $checkins)); ?>
							
	</div> <!-- End Stream -->

	
	<div class="clear"></div>
	
	<div id="location">
		<div class="wrapper">
			<div class="icon"></div>
			<div class="content"></div>
			<div class="share">

				<div class="facebook">
					<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D121539294561851&amp;layout=button_count&amp;show_faces=false&amp;width=10&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
				</div>

				<div class="twitter">
					<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://friendsonamap.com" data-text="Check out Friends on a Map — a cool way to visualize your friends checkins" data-count="horizontal" data-via="netspencer" data-related="pitch_ly">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>

			</div>
		</div>
	</div>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-9952430-5']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	
</body>
</html>