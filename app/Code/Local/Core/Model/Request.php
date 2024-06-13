<?php
class Core_Model_Request
{
    protected $_controllerName;
    protected $_moduleName;
    protected $_actionName;
    public function __construct()
    {
        $uri = $this->getRequestUri();
        $uri = array_filter(explode("/", $uri));
        $this->_moduleName = isset($uri[0]) ? $uri[0] : 'page';
        $this->_controllerName = isset($uri[1]) ? $uri[1] : 'index';
        $this->_actionName = isset($uri[2]) ? $uri[2] : 'index';
    }
    public function getParams($key = '')
    {
        return ($key == '')
            ? $_REQUEST
            : (isset($_REQUEST[$key])
                ? $_REQUEST[$key]
                : '');
    }
    public function getPostData($key = '')
    {
        return ($key == '')
            ? $_POST
            : (isset($_POST[$key])
                ? $_POST[$key]
                : '');
    }
    public function getQueryData($key = '')
    {
        return ($key == '')
            ? $_GET
            : (isset($_GET[$key])
                ? $_GET[$key]
                : '');
    }
    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
        return false;
    }
    public function getRequestUri()
    {
        $request = $_SERVER["REQUEST_URI"];
        $uri = str_replace("/Practice/Mvc/", "", $request);
        if (strpos($uri, "?")) {
            $uri = stristr($uri, '?', True);
        }
        return $uri;
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }
    public function getActionName()
    {
        return $this->_actionName;

    }
    public function getModuleName()
    {
        return $this->_moduleName;

    }
    public function getFullControllerClass()
    {
        $controllerClassName = $this->_moduleName . "_Controller_" . $this->_controllerName;
        $controllerClassName = ucwords($controllerClassName, "_");
        return $controllerClassName;
    }
}
