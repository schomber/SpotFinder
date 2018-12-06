<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:08
 */
use config\Config;
use view\TemplateView;
$this->spot;
?>
<div class="container spot-container">
    <form id="spot" method="post" action="update">
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4"><input id="name" class="form-control" type="hidden" name="id" required="" value="<?php echo TemplateView::noHTML(!empty($spot->getId()) ? $spot->getId() : ''); ?>"></div>
        </div>
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Spot Name<input id="name" class="form-control" type="text" name="name" required="" placeholder="Awesome Spot XYZ" value="<?php echo TemplateView::noHTML(!empty($spot->getName()) ? $spot->getName() : ''); ?>"></div>
        </div>
        <div class="form-row fadeElement" style="margin-top: 20px;">
            <div class="col"><div id="addMap"></div></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="address">Address</label>
                <input class="form-control" id="address" type="text" name="address" required="" placeholder="Langackerstrasse 11, 4142 Münchenstein" value="<?php echo TemplateView::noHTML(!empty($spot->getAddress()) ? $spot->getAddress() : ''); ?>" readonly>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="lat">Latitude</label>
                <input class="form-control" id="lat" type="text" name="latitude" required="" value="<?php echo !empty($spot->getLat()) ? $spot->getLat() : ''; ?>" readonly>
            </div>
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="lng">Longitude</label>
                <input class="form-control" id="lng" type="text" name="longitude" required="" value="<?php echo !empty($spot->getLng()) ? $spot->getLng() : ''; ?>" readonly>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                Category<select id="category" class="form-control" name="category" required="">
                    <optgroup label="Category">
                        <option value="Freestyle" <?php echo TemplateView::noHTML( ($spot->getCategory() == "Freestyle") ? 'selected=""' : ''); ?>>Freestyle</option>
                        <option value="Racing" <?php echo TemplateView::noHTML(($spot->getCategory() == "Racing") ? 'selected=""' : ''); ?>>Racing</option>
                        <option value="Longrange" <?php echo TemplateView::noHTML(($spot->getCategory() == "Longrange") ? 'selected=""' : ''); ?>>Longrange</option>
                        <option value="All" <?php echo TemplateView::noHTML(($spot->getCategory() == "All") ? 'selected=""' : ''); ?>>All</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Additional Comments?<textarea id="comment" class="form-control" rows="6" name="comment" value="<?php echo TemplateView::noHTML(!empty($spot->getComment()) ? $spot->getComment() : ''); ?>"></textarea></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4"><button class="btn btn-primary btn-block save" id="test" type="submit" style="margin-top: 0;">Save&nbsp;<i class="la la-save"></i></button></div>
        </div>
    </form>
</div>

<script>
    var map;
    var marker;
    var cityCircle;
    var myLatlng;
    var geocoder;

    function initMap() {
        myLatlng = new google.maps.LatLng(document.getElementById("lat").getAttribute("value"),document.getElementById("lng").getAttribute("value"));
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


        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition();
            myLatlng = {lat: event.latLng.lat(), lng: event.latLng.lng()};
            marker.setPosition(myLatlng);
            cityCircle.setCenter(myLatlng);
            toggleBounce();
            geocodeLatLng(geocoder, map, myLatlng);
            printLatLong(myLatlng);
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

    google.maps.event.addDomListener(window, 'load', initMap);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('google.apikey') ?>&callback=initMap"
        async defer>
</script>