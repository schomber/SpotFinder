<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:08
 */
use config\Config;
?>
<div class="container spot-container">
    <form id="spot" method="post" action="addSpot">
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Spot Name<input id="name" class="form-control" type="text" name="name" required="" placeholder="Awesome Spot XYZ"></div>
        </div>
        <div class="form-row fadeElement" style="margin-top: 20px;">
            <div class="col"><div id="addMap"></div></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <fieldset disabled="">Address<input class="form-control" id="address" type="text" name="address" required="" placeholder="Langackerstrasse 11, 4142 Münchenstein"></fieldset>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <fieldset disabled="">Latitude<input class="form-control" id="lat" type="text" name="latitude" required="" placeholder="47.55660371"></fieldset>
            </div>
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <fieldset disabled="">Longitude<input class="form-control" id="lng" type="text" name="longitude" required="" placeholder="7.58786201"></fieldset>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Category<select id="category" class="form-control" name="category" required=""><optgroup label="Category"><option value="Freestyle" selected="">Freestyle</option><option value="Racing">Racing</option><option value="Longrange">Longrange</option><option value="All">All</option></optgroup></select></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Additional Comments?<textarea id="comment" class="form-control" rows="6" name="comment"></textarea></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4"><button class="btn btn-primary btn-block save" id="test" type="submit" style="margin-top: 0;">Save&nbsp;<i class="la la-save"></i></button></div>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    //TODO TESTinggggg
    $('#spot').on('click', function() {
       var latitude = $('#spot').find('#lat').val();
       var longitude = $('#spot').find('#lng').val();
       var address = $('#spot').find('#address').val();
       var category = $('#spot').find('#category').val();
       var comment = $('#spot').find('#comment').val();
        var name = $('#spot').find('#name').val();

        $.ajax({
            method: "POST",
            url: "addSpot",
            data: {

                name:name,
                address:address,
                latitude: latitude,
                longitude: longitude,
                category: category,
                comment: comment
            }
        })
            .done(function() {
                console.log('success');

            })
            .fail(function() {
                console.log('error');
            })
    });

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

    google.maps.event.addDomListener(window, 'load', initMap);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('google.apikey') ?>&callback=initMap"
        async defer>
</script>