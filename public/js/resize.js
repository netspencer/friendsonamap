$(document).ready(function() {
	resize_elements();
	resize_elements_2();
});

$(window).resize(function() {
	resize_elements();
});


function resize_elements() {	
	header_height = $("#header").height();
	location_height = $("#location").height() + 1;
	
	stream_width = $("#stream").width();
	stream_height = $("#stream").height();
	
	window_width = $(window).width();
	window_height = $(window).height();
	
	$("#map").height(window_height - header_height - location_height);
	$("#stream").height(window_height - header_height - location_height);
	
	$("#map").width(window_width - 400);
	
	$("#stream").jScrollPane({animateTo:true});
}

function resize_elements_2() {	
	header_height = $("#header").height();
	location_height = $("#location").height() + 1;	
	window_width = $(window).width();
	
	$("#stream").height(window_height - header_height - location_height);
	$("#map").width(window_width - 400);
}