<?php
class Banner_Block_List extends Core_Block_Template
{
    public function __construct(){
        $this->setTemplate('banner/list.phtml');
    }
    public function getBanner()
    {
        return Mage::getModel("banner/banner")->getCollection();
    }
}
?>