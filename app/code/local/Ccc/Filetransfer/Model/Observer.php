<?php
class Ccc_Filetransfer_Model_Observer
{
    public function fetchfile()
    {
        $configCollection = Mage::getModel('filetransfer/configuration')->getCollection();
        foreach ($configCollection as $config) {
            $config->savefile();
        }
    }

    
}
?>