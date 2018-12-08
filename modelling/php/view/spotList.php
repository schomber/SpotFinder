<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:12
 */

use config\Config;
use view\TemplateView;
?>
<div class="container list-header spotLink" style="margin-top: 0;"><h1 class="text-center">SpotFinder</h1>
    <div class="row">
        <div class="col">
            <div class="form-group text-center" style="width: 100%;"><label style="font-size: 20px;"><i class="fa fa-search" style="font-size: 20px;color: rgb(255,198,0);"></i>Search&nbsp;</label><input class="border rounded" type="search" name="s_search" style="filter: blur(0px) brightness(95%);padding-left: 10px;font-weight: bold;max-width: 250px;"></div>
        </div>
    </div>

    <?php
    foreach ($this->spots as $spot): ?>
    <a href="<?php echo $GLOBALS["ROOT_URL"] . "/spot/display?id=" . $spot->getId()?>" style="display: block">
        <div class="row spotContainer" style="padding-top: 20px;padding-bottom: 5px;">
            <div class="col">
                <div class="row">
                    <div class="col-sm-12 col-lg-4 fadeElement" style="padding-bottom: 10px;padding-right: 15px;padding-left: 15px;padding-top: 0;">
                        <iframe
                                width="100%"
                                height="400"
                                align="center"
                                frameborder="0"
                                style="max-height: 310px; border:0"
                                src="https://www.google.com/maps/embed/v1/place?key=<?php echo TemplateView::noHTML(Config::get("google.apikey"))?>&q=<?php echo $spot->getAddress()?>&center=<?php echo TemplateView::noHTML($spot->getLat() . "," . $spot->getLng())?>&zoom=15" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="col-sm-12 col-lg-4" style="width: 100%;">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center"><?php echo "#" . $spot->getId()?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center"><strong>Spot Name</strong><br> <?php echo TemplateView::noHTML($spot->getName())?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>Spot Address</strong><br> <?php echo TemplateView::noHTML($spot->getAddress())?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>Spot Category</strong><br> <?php echo TemplateView::noHTML($spot->getCategory())?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center">SpotFinder: <?php echo TemplateView::noHTML($spot->getUsername())?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <a href="whatsapp://send?text=The text to share!" data-action="share/whatsapp/share">Share via Whatsapp</a>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="spot/edit?id=<?php echo $spot->getId() ?>" class="btn btn-info" type="button"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                            <a href="spot/delete?id=<?php echo $spot->getId() ?>" class="btn btn-danger" type="button"><i class="fa fa-remove"></i>&nbsp;Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><button class="btn btn-light" type="button" style="width: 160px;height: 50px;"><i class="fa fa-file-pdf-o border-success" style="color: rgb(220,53,69);height: px;font-size: 25px;"></i>&nbsp;PDF</button></td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-light whatsapp" type="button">
                                            <a href="whatsapp://send?text=
                                            <?php echo  $spot->getUsername(). " wants to share a " . $spot->getCategory() . " spot in" . $spot->getAddress() . " with you" ?>"
                                               data-action="<?php echo $GLOBALS["ROOT_URL"] . "/spot/display?id=" . $spot->getId()?>"></a>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>
