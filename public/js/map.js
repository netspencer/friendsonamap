/* JS FOR DEALING WITH THE MAP */

$(document).ready(function(){
	// init
	
	alert('test');
});

var map;

function createMap(lat, lon) {	
    if (GBrowserIsCompatible()) {
      map = new GMap2(document.getElementById("map"));
      map.setCenter(new GLatLng(lat, lon), 16);
    }
}

    
function moveMap(lat, lon) {
	latlng = new GLatLng(lat, lon);
	map.clearOverlays();
	map.addOverlay(new GMarker(latlng));
    map.panTo(latlng);
	reverseGeo(lat, lon);
}

function setLocationInfo(text) {
	$(".info #location").html(text);
}

var geocoder = new GClientGeocoder();

function reverseGeo(lat, lon) {
	latlng = new GLatLng(lat, lon);
	geocoder.getLocations(latlng, showAddress);
}

function showAddress(response) {
  if (!response || response.Status.code != 200) {
    //alert("Status Code:" + response.Status.code);
  } else {
    place = response.Placemark[0];
	state = place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName;
	city = place.AddressDetails.Country.AdministrativeArea.Locality.LocalityName;
	setLocationInfo(city+", "+state);
  }
}
