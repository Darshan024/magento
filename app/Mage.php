<?php
class Mage
{
    private static $registry = [];
    private static $_singleton = [];
    private static $baseDir = 'C:/xampp/htdocs/Practice/Mvc';
    private static $baseUrl = 'http://localhost/Practice/Mvc';
    public static function init()
    {
        $frontController = new Core_Controller_Front();
        $frontController->init();
    }
    public static function getModel($modelName)
    {
        $modelName = ucwords(str_replace("/", "_Model_", $modelName), "_");
        return new $modelName;
    }
    public static function getBlock($modelName)
    {
        $modelName = ucwords(str_replace("/", "_Block_", $modelName), "_");
        return new $modelName;
    }
    public static function getSingleton($className)
    {
        if (isset (self::$_singleton[$className])) {
            return self::$_singleton[$className];
        } else {
            return self::$_singleton[$className] = self::getModel($className);
        }
    }
    public static function register($key, $value)
    {

    }
    public static function registry($key)
    {

    }
    public static function getBaseDir($subDir = null)
    {
        if ($subDir) {
            return self::$baseDir . '/' . $subDir;
        }
        return self::$baseDir;
    }
    public static function getBaseUrl($subDir = null)
    {
        if ($subDir) {
            return self::$baseUrl . '/' . $subDir;
        }
        return self::$baseUrl . "/";
    }

}

?>