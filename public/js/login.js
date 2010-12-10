$(document).ready(function() {

	$("ul.login li a.login").click(function() {
		$(this).parents("li").find("form").toggle();
	});
	
});