<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 09.12.2018
 * Time: 19:59
 */

namespace services;
use config\Config;


class PDFServiceClient
{
    public static function sendPDF($htmlData){
        $jsonObj = self::createPDFJSONObj();
        $jsonObj->user = Config::get("pdf.hypdf-user");
        $jsonObj->password = Config::get("pdf.hypdf-password");
        $jsonObj->content = $htmlData;

        $options = ["http" => [
            "method" => "POST",
            "header" => ["Content-Type: application/json"],
            "content" => json_encode($jsonObj)
        ]];
        $context = stream_context_create($options);
        $response = file_get_contents("https://www.hypdf.com/htmltopdf", false, $context);
        if(strpos($http_response_header[0],"200"))
            return $response;
        return false;
    }

    protected static function createPDFJSONObj(){
        return json_decode('{"content": "HTML", "user": "HYPDF_USER", "password": "YOUR_HYPDF_PASSWORD", "test": "true"}');
    }
}