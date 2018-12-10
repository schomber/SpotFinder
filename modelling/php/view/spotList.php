<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:12
 */

use config\Config;
use view\TemplateView;
use services\AuthServiceImpl;

?>
<div class="container list-header spotLink" style="margin-top: 0;"><h1 class="text-center">SpotFinder</h1>
    <div class="row">
        <div class="col">
            <div class="form-group text-center" style="width: 100%;"><label style="font-size: 20px;"><i class="fa fa-search" style="font-size: 20px;color: rgb(255,198,0);"></i>Search&nbsp;</label><input class="border rounded" type="search" name="s_search" style="filter: blur(0px) brightness(95%);padding-left: 10px;font-weight: bold;max-width: 250px;"></div>
        </div>
    </div>

    <?php
    foreach ($this->spots as $spot):?>
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
                                    <th class="text-center">Information</th>
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
                                    <th class="text-center">Action & Share</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (AuthServiceImpl::getInstance()->getCurrentCustomerId() == $spot->getUserid() || AuthServiceImpl::getInstance()->verfiyAdmin()) {?>
                                    <tr>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="spot/edit?id=<?php echo $spot->getId() ?>" class="btn btn-light" type="button"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                                <a href="spot/delete?id=<?php echo $spot->getId() ?>" class="btn btn-danger" type="button"><i class="fa fa-remove"></i>&nbsp;Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="spot/pdf?id=<?php echo $spot->getId() ?>" class="whatsapp btn " type="button"><i class="fa fa-file-pdf-o border-success" style="color: rgb(220,53,69);font-size: 25px; padding-top: 10px"></i>&nbsp;PDF</a>
                                                <a class="whatsapp" target="_blank" type="button" href="https://wa.me/?text=<?php echo urlencode($GLOBALS["ROOT_URL"] . "/spot/display?id=" . $spot->getId())?>" data-action="share/whatsapp/share">
                                                    <img src="assets/img/WhatsApp.png" width="60" height="60">
                                                </a>
                                            </div>
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
