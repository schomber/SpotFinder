var map;
var marker;
var cityCircle;
var myLatlng;
var geocoder;

function initMap() {

    //check if add or edit
    myLatlng = new google.maps.LatLng(document.getElementById("lat").getAttribute("value"),document.getElementById("lng").getAttribute("value"));
    geocoder = new google.maps.Geocoder;

    map = new google.maps.Map(document.getElementById('addMap'), {
        center: myLatlng,
        zoom: 18,
        mapTypeId: 'satellite'
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
