<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 09.12.2018
 * Time: 20:33
 */

namespace controller;

use services\SpotServiceImpl;
use view\TemplateView;
use services\PDFServiceClient;
class PDFController
{
    public static function generatePDFSpot() {
        $pdfView = new TemplateView("spotPDF.php");
        $pdfView->spot = (new SpotServiceImpl())->readSpot($_GET["id"]);
        $result = PDFServiceClient::sendPDF($pdfView->render());
        header("Content-Type: application/pdf", NULL, 200);
        echo $result;
    }
}