<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 16:53
 */

namespace view;

use services\PDFServiceClient;

class LayoutRendering
{
    public static function basicLayout(TemplateView $contentView) {
        $view = new TemplateView("layout.php");
        $view->header = (new TemplateView("header.php"))->render();
        $view->content = $contentView->render();
        $view->footer = (new TemplateView("footer.php"))->render();
        echo $view->render();
    }
}