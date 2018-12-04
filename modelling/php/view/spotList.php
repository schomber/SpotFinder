<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:12
 */

use config\Config;
?>
<div class="container list-header" style="margin-top: 0;"><h1 class="text-center">SpotFinder</h1>
    <div class="row">
        <div class="col">
            <div class="form-group text-center" style="width: 100%;"><label style="font-size: 20px;"><i class="fa fa-search" style="font-size: 20px;color: rgb(255,198,0);"></i>Search&nbsp;</label><input class="border rounded" type="search" name="s_search" style="filter: blur(0px) brightness(95%);padding-left: 10px;font-weight: bold;max-width: 250px;"></div>
        </div>
    </div>

    <?php
    global $spots;
    foreach ($spots as $spot): ?>
    <div class="row spotContainer" style="padding-top: 20px;padding-bottom: 5px;">
        <div class="col">
            <div class="row">
                <div class="col-sm-12 col-md-4" style="padding: 0;padding-right: 15px;padding-left: 15px;padding-top: 0;">
                    <iframe allowfullscreen="" frameborder="0" width="100%" height="550"
                        src="https://www.google.com/maps/embed/v1/view
                              ?key=AIzaSyCuXnCcm1Sq61688xAtHoCGRA5GcNYVxTA
                              &center=-33.8569,151.2152
                              &zoom=18
                              &maptype=satellite"
                            style="max-height: 300px;">
                    </iframe></div>
                <div class="col-sm-12 col-md-4" style="width: 100%;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center"><?php echo "#" . $spot['id']?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center"><strong>Spot Name</strong><br> <?php echo $spot['name']?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Spot Address</strong><br> <?php echo $spot['address']?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>Spot Category</strong><br> <?php echo $spot['category']?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">SpotFinder: <?php echo $spot['category']?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">
                                    <div class="btn-group" role="group"><button class="btn btn-info" type="button"><i class="fa fa-edit"></i>&nbsp;Edit</button><button class="btn btn-danger" type="button"><i class="fa fa-remove"></i>&nbsp;Delete</button></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><button class="btn btn-light" type="button" style="width: 160px;height: 50px;"><i class="fa fa-file-pdf-o border-success" style="color: rgb(220,53,69);height: px;font-size: 25px;"></i>&nbsp;PDF</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
