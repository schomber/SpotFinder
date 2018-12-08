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
                        <option value="Freestyle" <?php echo  ($spot->getCategory() == "Freestyle") ? 'selected=""' : ""; ?>>Freestyle</option>
                        <option value="Racing" <?php echo ($spot->getCategory() == "Racing") ? 'selected=""' : ''; ?>>Racing</option>
                        <option value="Longrange" <?php echo ($spot->getCategory() == "Longrange") ? 'selected=""' : ''; ?>>Longrange</option>
                        <option value="All" <?php echo ($spot->getCategory() == "All") ? 'selected=""' : ''; ?>>All</option>
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

<script src="assets/js/editSpot.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('google.apikey') ?>&callback=initMap"
        async defer>
</script>