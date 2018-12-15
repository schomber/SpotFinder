<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 21.11.2018
 * Time: 15:39
 */

namespace config;


class Config
{

    protected static $iniFile = "config/config.env";
    protected static $config = [];

    public static function init()
    {
        if (file_exists(self::$iniFile)) {
            self::$config = parse_ini_file(self::$iniFile);
        } else if (file_exists("../". self::$iniFile)) {
            self::$config = parse_ini_file("../". self::$iniFile);
        } else {
            self::loadENV();
        }
    }

    public static function get($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config[$key];
    }

    private static function loadENV(){
        if (isset($_ENV["DATABASE_URL"])) {
            $dbopts = parse_url($_ENV["DATABASE_URL"]);
            self::$config["database.dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"], '/') . "; sslmode=require";
            self::$config["database.user"] = $dbopts["user"];
            self::$config["database.password"] = $dbopts["pass"];
        }
        if (isset($_ENV["GOOGLE_APIKEY"])) {
            self::$config["google.apikey"] = $_ENV["GOOGLE_APIKEY"];
        }
        if (isset($_ENV["HYPDF_USER"])) {
            self::$config["pdf.hypdf-user"] = $_ENV["HYPDF_USER"];
        }
        if (isset($_ENV["HYPDF_PASSWORD"])) {
            self::$config["pdf.hypdf-password"] = $_ENV["HYPDF_PASSWORD"];
        }
            if (isset($_ENV["SENDGRID_APIKEY"])) {
            self::$config["email.sendgrid-apikey"] = $_ENV["SENDGRID_APIKEY"];
        }
    }

}