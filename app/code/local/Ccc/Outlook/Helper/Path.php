<?php
class Ccc_Outlook_Helper_Path extends Mage_Core_Helper_Abstract
{
    public function getBasePath(){
        return  Mage::getBaseDir('var') . DS . 'attachments' . DS;
    }
}
?>