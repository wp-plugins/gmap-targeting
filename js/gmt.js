function gmt_init_map(Lat,Lng, map_canvas_id, zoom, maptype,info) {
    var latLng = new google.maps.LatLng(Lat, Lng);
    var homeLatLng = new google.maps.LatLng(Lat, Lng);

    switch(maptype){
	case "SATELLITE":
	    maptype=google.maps.MapTypeId.SATELLITE;
	    break;

	case "HYBRID":
	    maptype=google.maps.MapTypeId.HYBRID;
	    break;

	case "TERRAIN":
	    maptype=google.maps.MapTypeId.TERRAIN;
	    break;

	default:
	    maptype=google.maps.MapTypeId.ROADMAP;
	    break;

    }

    var map = new google.maps.Map(document.getElementById(map_canvas_id), {
	zoom: zoom,
	center: latLng,
	mapTypeId: maptype
    });

    var marker = new MarkerWithLabel({
	position: homeLatLng,
	draggable: false,
	map: map
    });

    var iw = new google.maps.InfoWindow({
	content: '<span>'+info+'</span>'
    });
    google.maps.event.addListener(marker, "click", function (e) {
	iw.open(map, marker);
    });
}



