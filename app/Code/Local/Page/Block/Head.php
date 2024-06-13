<?php
class Page_Block_Head extends Core_Block_Template
{
    protected $_css = [];
    protected $_js = [];
    public function __construct()
    {
        $this->setTemplate('page/head.phtml');
        $this->addJs('jquery-3.7.1.js');
    }
    public function addJs($file)
    {
        $this->_js[] = 'skin/js/' . $file;
    }
    public function addCss($file)
    {
        $this->_css[] = 'skin/css/' . $file;

    }
    public function getJs()
    {
        return $this->_js;
    }
    public function getCss()
    {
        return $this->_css;

    }
}
?>