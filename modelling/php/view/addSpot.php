<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:08
 */
?>
<div class="container spot-container">
    <form method="post">
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <fieldset disabled=""><input class="form-control" type="text" name="s_ID" required="" placeholder="ID"></fieldset>
            </div>
        </div>
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><input class="form-control" type="text" name="s_title" required="" placeholder="spot name"></div>
        </div>
        <div class="form-row fadeElement" style="margin-top: 20px;">
            <div class="col"><div id="addMap"></div></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><input class="form-control" type="text" name="s_address" required="" placeholder="Langackerstrasse 11, 4142 Münchenstein"></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><select class="form-control" name="s_category" required=""><optgroup label="Category"><option value="0" selected="">Freestyle</option><option value="1">Racing</option><option value="2">Longrange</option><option value="3">everything</option></optgroup></select></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><textarea class="form-control" rows="6" name="s_comment" placeholder="additional comments?"></textarea></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4"><button class="btn btn-primary btn-block save" type="submit" style="margin-top: 0;">Save&nbsp;<i class="la la-save"></i></button></div>
        </div>
    </form>
</div>

<script>
    var map, infoWindow;
    var label = 'S';
    var marker;
    var cityCircle;
    var myLatlng;





    function initMap() {
        myLatlng = new google.maps.LatLng(47.55660371,7.58786201);
        //var geocoder = new google.maps.Geocoder;

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
            radius: 100
        });

        marker = new google.maps.Marker({
            position: myLatlng,
            label: label,
            map: map
        });

        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition();
            myLatlng = {lat: event.latLng.lat(), lng: event.latLng.lng()}
            marker.setPosition(myLatlng);
            cityCircle.setCenter(myLatlng);
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

                map.setCenter(myLatlng);
            }, function() {
                handleLocationError(true, infoWindow, myLatlng);
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }


    }

    function createRadiusCircle(location, map) {
        var cityCircle = new google.maps.Circle({
            strokeColor: '#000000',
            strokeOpacity: 0.7,
            strokeWeight: 1,
            fillColor: '#8eff88',
            fillOpacity: 0.4,
            map: map,
            center: location,
            radius: 500
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuXnCcm1Sq61688xAtHoCGRA5GcNYVxTA&callback=initMap"
        async defer>
</script>