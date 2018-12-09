<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>SpotFinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean-1.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean">
            <div class="container"><a class="navbar-brand" href="<?php echo $GLOBALS["ROOT_URL"]; ?>"><i class="fa fa-map-o"></i>&nbsp;SpotFinder</a>
            </div>
        </nav>
    </div>
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
            <div class="col-sm-12 col-md-4 offset-sm-0 offset-md-4">Spot Name<input readonly id="name" class="form-control" type="text" name="name" value="<?php echo TemplateView::noHTML(!empty($spot->getName()) ? $spot->getName() : ''); ?>"></div>
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
    </form>
</div>

<script src="assets/js/Spot.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get('google.apikey') ?>&callback=initMap"
        async defer>
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>