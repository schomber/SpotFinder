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
                <label for="address">Address</label>
                <input class="form-control" id="address" type="text" name="address" required="" placeholder="Langackerstrasse 11, 4142 Münchenstein" readonly>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="lat">Latitude</label>
                <input class="form-control" id="lat" type="text" name="latitude" required="" readonly>
            </div>
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="lng">Longitude</label>
                <input class="form-control" id="lng" type="text" name="longitude" required="" readonly>
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

<script src="assets/js/addSpot.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('google.apikey') ?>&callback=initMap"
        async defer>
</script>