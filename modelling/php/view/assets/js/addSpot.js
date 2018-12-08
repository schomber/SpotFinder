var map, infoWindow;
var marker;
var cityCircle;
var myLatlng;
var geocoder;

function initMap() {
    myLatlng = new google.maps.LatLng(47.55660371,7.58786201);
    geocoder = new google.maps.Geocoder;

    map = new google.maps.Map(document.getElementById('addMap'), {
        center: myLatlng,
        zoom: 16
    });

    cityCircle = new google.maps.Circle({
        strokeColor: '#FFC600',
        strokeOpacity: 0.9,
        strokeWeight: 1,
        fillColor: '#FFC600',
        fillOpacity: 0.2,
        center: myLatlng,
        map: map,
        radius: 50
    });

    marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        animation: google.maps.Animation.DROP
    });
    printLatLong(myLatlng);
    geocodeLatLng(geocoder, map, myLatlng);

    google.maps.event.addListener(map, 'click', function(event) {
        marker.setPosition();
        myLatlng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
        marker.setPosition(myLatlng);
        cityCircle.setCenter(myLatlng);
        toggleBounce();
        geocodeLatLng(geocoder, map, myLatlng);
        printLatLong(myLatlng);
    });

    // HTML 5 Geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            myLatlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            marker.setPosition(myLatlng);
            cityCircle.setCenter(myLatlng);
            geocodeLatLng(geocoder, map, myLatlng);
            printLatLong(myLatlng);

            map.setCenter(myLatlng);
        }, function() {
            handleLocationError(true, infoWindow, myLatlng);
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function printLatLong(location) {
    document.getElementById("lat").setAttribute('value', location.lat);
    document.getElementById("lng").setAttribute('value', location.lng);
}

function toggleBounce() {
    marker.setAnimation(google.maps.Animation.BOUNCE);
}

function geocodeLatLng(geocoder, map, location) {
    geocoder.geocode({'location': location}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                document.getElementById("address").setAttribute('value', results[0].formatted_address);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}
