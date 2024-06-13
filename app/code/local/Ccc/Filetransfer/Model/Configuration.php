<?php
class Ccc_Filetransfer_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('filetransfer/configuration');
    }
    public function savefile()
    {
        $ftpModel = Mage::getModel('filetransfer/ftp');
        $ftpModel->setConfigObj($this);
        $allFiles=$ftpModel->fetchAllfiles();
        $fileModel = Mage::getModel('filetransfer/file');
        foreach($allFiles as $file){
            $file['config_id'] = $this->getId();
            $fileModel->setData($file)->save();
        }
    }
}
?>