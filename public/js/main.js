
/* DOCUMENT DID FINISH LOADING */

$(document).ready(function() {
	toggleManage();
	createMap();
	setCurrentOnHover();
	leaveComment();
	streamController('setup');
});

/* KEY LISTENERS */

$(document).keydown(function(e)
	{
		switch(e.which)
		{
			case 32:
				// spacebar
				streamController('toggle');
				return false;
				break;
			case 37:
				// left arrow
				streamController('previous');
				return false;
				break;	
			case 38:
				// up arrow
				streamController('previous');
				return false;
				break;
			case 39:
				// right arrow
				streamController('next');
				return false;
				break;
			case 40:
				// down arrow
				streamController('next');
				return false;
				break;
		
		}
});
	
/* Item STREAM */

var interval;

function streamController(control) {
	controller = $(".streamController");
	switch(control) {
		case 'setup':
			// setup
			setCurrentItem(1);
			//streamController('play');
			mapToggleControl('add');
			findMarkers();
			break;
		case 'pause':
			// pause
			controller.find(".pause").removeClass("pause").addClass("play");
			clearInterval(interval);
			interval = null;
			//mapToggleControl('add');
			break;
		case 'play':
			// play
			controller.find(".play").removeClass("play").addClass("pause");
			interval = setInterval("streamController('next')", 5000);
			//streamController('next');
			//mapToggleControl('add');
			break;
		case 'toggle':
			if (interval) {
				streamController('pause');
			} else {
				streamController('play');
			}
			break;
		case 'next':
			current = $(".checkin.current");
			next = current.next();
			
			if (next.hasClass('ad')) {
				next = next.next();
			}
			
			if (next.length>0) {
				id = next.attr("row");
				setCurrentItem(id);
				streamController('scroll');
			} else {
				setCurrentItem(1);
				streamController('scroll');
			}
			break;
		case 'previous':
			current = $(".checkin.current");
			previous = current.prev();
			
			if (previous.hasClass('ad')) {
				previous = previous.prev();
			}
			
			if (previous.length>0) {
				id = previous.attr("row");
				setCurrentItem(id);
				streamController('scroll');
			} else {
				last = $(".checkin:last");
				last = last.attr("row");
				setCurrentItem(last);
				streamController('scroll');
			}
			break;
		case 'scroll':
			$("div#stream")[0].scrollTo(".checkin.current");
			break;
	}
}

function showMessageOnHover() {
	$('.checkin[title]').qtip({style: {
		name:'light',
		'font-family': 'Helvetica'
	},
	position: {
		corner: {
			target: 'rightMiddle'
		}
	}});
}

function leaveComment(id, comment) {
	$(".checkin span.comment").click(function(){
		Item = $(this).parents('.checkin');
		
		id = Item.attr("checkin_id");
		
		comment = prompt('Leave a comment ('+checkin_id+'): *this will be prettier eventually');
		
		if (comment.length>0) {
			$.post("/index.php/test/comment/"+id, {message: comment});
		} else {
			// no comment left
		}
	});
	
	$(".checkin span.like").click(function(){
		Item = $(this).parents('.checkin');
		
		id = Item.attr("checkin_id");
				
		$.post("/index.php/test/like/"+id);
		alert('This feature doesn\'t work yet. :(');
	});
}

function setCurrentOnHover() {
	$(".checkin").click(function(){
		id = $(this).attr("row");
		checkin_id = $(this).attr("checkin_id");
		setCurrentItem(id);
		streamController('pause');
	});
}

function setCurrentItem(id) {
	$(".checkin").removeClass("current");
	row = $("[row=\'"+id+"\']");
	row.addClass("current");
	lat = row.find("lat").text();
	lon = row.find("lon").text();
	lat = parseFloat(lat);
	lon = parseFloat(lon);	
	moveMap(lat,lon);
//	map.removeOverlay(marker[2]);
}

function createFiller() {
	lastItemHeight = $(".checkin:last").height();
	targetHeight = 600;
	newHeight = targetHeight - lastItemHeight - 50;
	$("#filler").height(newHeight);
	$("div#stream").jScrollPane({animateTo:true});
}

/* GMAPS */

var map;

function createMap() {	
	row = $("[row=\'1\']");
	lat = row.find("lat").text();
	lon = row.find("lon").text();
	lat = parseFloat(lat);
	lon = parseFloat(lon);
    if (GBrowserIsCompatible()) {
    	map = new GMap2(document.getElementById("map"));
    	map.setCenter(new GLatLng(lat, lon), 12);
    }

/*
	GEvent.addListener(map, "click", function() {
	  alert("You clicked the map.");
	});*/
}

var mapController = new GLargeMapControl3D();

var marker = [];

function findMarkers() {
	
	$("#stream .checkin").each(function(){
		id = $(this).attr('row');
		lat = $(this).find('lat').text();
		lon = $(this).find('lon').text();
		place = $(this).find('p.text').text();
		avatar = $(this).find('img.avatar').attr('src');
		
		
		/* icon */
		icon = new GIcon(G_DEFAULT_ICON);
		icon.image = avatar;
		icon.iconSize = new GSize(25, 25);
		
		//alert(avatar);
		
		latlng = new GLatLng(lat, lon);
		marker[id] = new GMarker(latlng, {icon:icon, title:id});
		
		map.addOverlay(marker[id]);
		
		GEvent.addListener(marker[id], "click", function() {
			id = this.getTitle();
			setCurrentItem(id);
			streamController('scroll');
		});
	});
}

function setupMarkers() {
	var mgr = new MarkerManager(map);
	
    for (var j in layer["places"]) {
		var place = layer["places"][j];
		var icon = getIcon(place["icon"]);
		var posn = new GLatLng(place["posn"][0], place["posn"][1]);
		markers.push(new GMarker(posn, { title: place["name"], icon: icon }));
    }

	mgr.addMarkers(markers, layer["zoom"][0], layer["zoom"][1]);
	mgr.refresh();
}

function mapToggleControl(toggle) {
	switch(toggle) {
		case 'add':
			map.addControl(mapController);
			break;
		case 'remove':
			map.removeControl(mapController);
			break;
	}
}

    
function moveMap(lat, lon) {
	latlng = new GLatLng(lat, lon);
//	map.clearOverlays();
//	map.addOverlay(new GMarker(latlng));
    map.panTo(latlng);
	reverseGeo(lat, lon);
}

function setLocationInfo(text) {
	$("#location .content").html(text);
}

var geocoder = new GClientGeocoder();

function reverseGeo(lat, lon) {
	latlng = new GLatLng(lat, lon);
	geocoder.getLocations(latlng, showAddress);
}

function showAddress(response) {
  if (!response || response.Status.code != 200) {
    setLocationInfo("Status Code:" + response.Status.code);
  } else {
    place = response.Placemark[0];
	address = place.address;
	state = place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
	setLocationInfo(address);
  }
}

function toggleManage() {
	$("a.manage").click(function() {
		$("#manage").toggle();
		return false;
	});
}
