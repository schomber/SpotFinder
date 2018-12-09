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
    <form id="spot">
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Spot Finder<input readonly id="finder" class="form-control" type="text" name="name" required="" placeholder="Awesome Spot XYZ" value="<?php echo TemplateView::noHTML(!empty($spot->getUsername()) ? $spot->getUsername() : ''); ?>"></div>
        </div>
        <div class="form-row" style="margin-top: 0px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Spot Name<input readonly id="name" class="form-control" type="text" name="name" required="" placeholder="Awesome Spot XYZ" value="<?php echo TemplateView::noHTML(!empty($spot->getName()) ? $spot->getName() : ''); ?>"></div>
        </div>
        <div class="form-row fadeElement" style="margin-top: 20px;">
            <div class="col"><div id="addMap"></div></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="address">Address</label>
                <input class="form-control" id="address" type="text" name="address" value="<?php echo TemplateView::noHTML(!empty($spot->getAddress()) ? $spot->getAddress() : ''); ?>" readonly>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="lat">Latitude</label>
                <input class="form-control" id="lat" type="text" name="latitude"  value="<?php echo !empty($spot->getLat()) ? $spot->getLat() : ''; ?>" readonly>
            </div>
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="lng">Longitude</label>
                <input class="form-control" id="lng" type="text" name="longitude" value="<?php echo !empty($spot->getLng()) ? $spot->getLng() : ''; ?>" readonly>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">
                <label for="address">Category</label>
                <input class="form-control" id="category" type="text" name="category" value="<?php echo TemplateView::noHTML(!empty($spot->getCategory()) ? $spot->getCategory() : ''); ?>" readonly>
            </div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Additional Comments<textarea readonly id="comment" class="form-control" rows="6" name="comment"><?php echo TemplateView::noHTML(!empty($spot->getScomment()) ? $spot->getScomment() : ''); ?></textarea></div>
        </div>
        <div class="form-row" style="margin-top: 20px;">
            <div class="col-sm-12 col-md-4 offset-md-4">
                <a href="<?php echo $GLOBALS["ROOT_URL"] ?>">
                    <button class="btn btn-primary btn-block save" id="test" type="button" style="margin-top: 0;">Back to Spot List</button>
                </a>
            </div>
        </div>
    </form>
</div>

<script src="assets/js/Spot.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('google.apikey') ?>&callback=initMap"
        async defer>
</script>