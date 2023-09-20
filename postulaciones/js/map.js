function mapa(macc) {
	//la macc recibida es un array de valores para setear el mapa
	var place;
	var lat = macc.lat;
	var lng = macc.lng;
	var zoom = macc.zoom;
	
	const map = new google.maps.Map(document.getElementById('map'), {
		//center: { lat: lati, lng: longi },
		center: {lat: lat,lng: lng},
		zoom: zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	const geocoder = new google.maps.Geocoder();
	const marker = new google.maps.Marker({
		map,
		anchorPoint: new google.maps.Point(0, -29),
		draggable: true,
		position: new google.maps.LatLng(lat, lng)
	});
/*	
	const card = document.getElementById("pac-card");
	const input = document.getElementById("pac-input");
	const options = {
		componentRestrictions: { country: "pe" },
		fields: ["formatted_address", "geometry", "name"],
		strictBounds: false,
		types: ["establishment"],
	};
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
	const autocomplete = new google.maps.places.Autocomplete(input, options);
	// Bind the map's bounds (viewport) property to the autocomplete object,
	// so that the autocomplete requests use the current map bounds for the
	// bounds option in the request.
	autocomplete.bindTo("bounds", map);
	const infowindow = new google.maps.InfoWindow();
	const infowindowContent = document.getElementById("infowindow-content");
	infowindow.setContent(infowindowContent);
	
	autocomplete.addListener("place_changed", () => {
		infowindow.close();
		marker.setVisible(false);
		place = autocomplete.getPlace();
		if (!place.geometry || !place.geometry.location) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			window.alert("No details available for input: '" + place.name + "'");
			return;
		}
			// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		}else {
			map.setCenter(place.geometry.location);
			//map.setZoom(16);
		}
		marker.setPosition(place.geometry.location);	
		marker.setVisible(true);
		infowindowContent.children["place-name"].textContent = place.name;
		infowindowContent.children["place-address"].textContent = place.formatted_address;
		infowindow.open(map, marker);
		
		//lat = place.geometry.location.lat();
		//lng = place.geometry.location.lng();
		//console.log(lat+",  "+lng);
	});
*/
		  
	google.maps.event.addListener(marker, "dragend", function (event) {		
		//document.getElementById("latitud").value = lat;
		//document.getElementById("longitud").value = lng;
		geocoder.geocode({'latLng': marker.getPosition()},function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				//console.log  (results[0].address_components);
				//var address = results[0]['formatted_address'];
				//infowindowContent.children["place-name"].textContent = results[0].geometry.location;
				//infowindowContent.children["place-address"].textContent = results[0]['formatted_address'];
				//infowindow.open(map, marker);
			}
		});
		lat = marker.getPosition().lat();
		lng = marker.getPosition().lng();
		$('#lat').val(lat);
		$('#lng').val(lng);
		//console.log(lat+",  "+lng);
	});
	
	google.maps.event.addListener(map,"center_changed", () => {
		// 3 seconds after the center of the map has changed, pan back to the marker.
		//var c = map.getCenter();
		//console.log(c);
		//map.setZoom(16);
		marker.setPosition(map.getCenter());
		lat = marker.getPosition().lat();
		lng = marker.getPosition().lng();
		$('#lat').val(lat);
		$('#lng').val(lng);
		//window.setTimeout(() => { map.panTo(marker.getPosition()); lat = marker.getPosition().lat(); lng = marker.getPosition().lng(); console.log(lat+",  "+lng); }, 3000);
	});
	
	google.maps.event.addListener(marker, "position_changed", function() {
		/*lat = marker.getPosition().lat();
		lng = marker.getPosition().lng();
		console.log(lat+",  "+lng);
		console.log(marker.getPosition());*/
	});
	
	google.maps.event.addListener(marker,"click", () => {
		//map.setZoom(8);
		//map.setCenter(marker.getPosition());
	});	
	
	//Evento que se produce cuando cambia cualquier cosa en la ventana del mapa
	google.maps.event.addListener(map, 'bounds_changed', function(event) {
		
    });
	
	return map;
}