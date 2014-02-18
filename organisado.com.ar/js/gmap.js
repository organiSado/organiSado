/* globals */
var start_latitude  = -41.10958761299646;
var start_longitude = -71.35643566894531;

var start_zoom      		= 9;
var max_zoom_level 			= 18;
var small_zoom_step 		= 1;
var small_zoom_threshold	= 15;
var big_zoom_step 			= 2;


var fieldLat, fieldLong;

var geocoder, map, marker, infoWindow;

var lastValue, typingTimer, scheduleTimeout = 500;

/*! \brief function call scheduler, anti overwhelm
*/
function scheduleCall(obj, f)
{
	if( obj && obj.value != lastValue )
	{
		lastValue = obj.value;

		clearTimeout(typingTimer);
		
		typingTimer = setTimeout(function() {
			f(obj.value);
		}, scheduleTimeout);
	}
}

/*! \brief New Google Maps API v3 editor implementation
*/
function initEditorMap(mapDiv, lat, long, zoom, latfieldname, longfieldname)
{
	// DEFAULT
    if (!mapDiv) 		mapDiv 			= 'map';
    if (!latfieldname) 	latfieldname 	= 'Events_location_lat';
    if (!longfieldname) longfieldname 	= 'Events_location_long';

	fieldLat 	= document.getElementById(latfieldname);
	fieldLong 	= document.getElementById(longfieldname);


	// ZOOM
    var zoomlevel = start_zoom;
	if (zoom)
	{
		zoomlevel = zoom;
	}
	else if ( fieldLat && fieldLat.value
			  && fieldLong && fieldLong.value )
    {
		zoomlevel = max_zoom_level;
	}

    // LATITUDE
    var latitude = start_latitude;
	if (lat)
    {
		latitude = lat;
	}
    else if ( fieldLat && fieldLat.value )
    {
        latitude = fieldLat.value;
	}
    
	// LONGITUDE
    var longitude = start_longitude;
	if (long)
    {
		longitude = long;
	}
    else if ( fieldLong && fieldLong.value )
    {
		longitude = fieldLong.value;
	}

	// GEOCODER
	geocoder = new google.maps.Geocoder();
        
	// CREATE MAP
    var pos = new google.maps.LatLng(latitude, longitude);
    var mapOptions = {
          center: pos,
          zoom: zoomlevel,
          
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          
          // Add controls
          mapTypeControl: true,
          //scaleControl: true,
          overviewMapControl: true,
          overviewMapControlOptions: 
          {
            opened: true
          }
        };
        
    map = new google.maps.Map(document.getElementById(mapDiv), mapOptions);

	// MARKER
    var markerOptions = {
            position: pos,
            map: map,
            draggable: true,
    		animation: google.maps.Animation.DROP,
        };
    
    marker = new google.maps.Marker(markerOptions);

    // INFO WINDOW
    var infoWindowOptions = {
    	content: "Esta será tu nueva <strong>ubicación</strong>..."
    };

    infoWindow = new google.maps.InfoWindow(infoWindowOptions);
    
	// DRAG START
	google.maps.event.addListener(marker, "dragstart", function(event) {
		infoWindow.close();
	});

	// DRAG END
	google.maps.event.addListener(marker, "dragend", function(event) {
		// current data
		var curZoom = map.getZoom();
		var curPos = marker.position;

		// New Zoom
		var nuZoom = curZoom;
		if (nuZoom < small_zoom_threshold)
		{
			nuZoom += big_zoom_step;
		}
		else
		{
			nuZoom += small_zoom_step;
		}

		if (nuZoom < max_zoom_level)
		{
			map.setZoom(nuZoom);
			map.setCenter(curPos);
		}
		else
		{
			infoWindow.open(map,marker);
		}

		if (fieldLat)	fieldLat.value 	= curPos.lat();
		if (fieldLong)	fieldLong.value = curPos.lng();
	});


}

/*! \brief New Google Maps API v3 reset implementation
*/
function resetMap()
{
	document.getElementById('field_latitude').value = '';
	document.getElementById('field_longitude').value = '';
	initEditorMap();
}


/*! \brief New Google Maps API v3 find address implementation
*/
function findAddressInEditorMap(address, mapDiv)
{
	address += ", San Carlos de Bariloche, Río Negro, Argentina";

	if (!mapDiv) mapDiv = "map";
	
	if (!map) initEditorMap();

	geocoder.geocode( { 'address': address }, function(results, status)
	{
	    if (status == google.maps.GeocoderStatus.OK)
	    {
			map.setCenter(results[0].geometry.location);
			map.setZoom(max_zoom_level);

			marker.setPosition(results[0].geometry.location);

			if (fieldLat)	fieldLat.value 	= results[0].geometry.location.lat();
			if (fieldLong)	fieldLong.value = results[0].geometry.location.lng();
            
            infoWindow.open(map,marker);
	    }
	    else
	    {
	    	alert('Por favor, ingrese la locación manualmente. No pudimos encontrar la dirección debido a: ' + status);
	    }
	});
}


/* API 2 
function findAddress(address, mapDiv) {
	var address = address+", San Carlos de Bariloche, Río Negro, Argentina";
	if (mapDiv == null) var mapDiv = "map";
	if (map == null) { 
			if (mapDiv == null) var mapDiv = "map";
			// CREATE MAP
			var map = new GMap(document.getElementById(mapDiv));
			map.enableScrollWheelZoom();
			// ADD CONTROLS
			map.addControl(new GLargeMapControl3D());
			map.addControl(new GOverviewMapControl());
	}
	geocode = new GClientGeocoder();
	geocode.getLatLng(address, function(point) {
		if (point) {
			map.setCenter(point, 16);
			var marker = new GMarker(point, {draggable: false});
			map.addOverlay(marker);
		}
	});
	if (document.getElementById(mapDiv).style.display == 'none') { document.getElementById(mapDiv).style.display = ''; }
}*/