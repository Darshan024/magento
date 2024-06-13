<?php
class Ccc_Outlook_Model_Email extends Mage_Core_Model_Abstract
{
    protected $_config;
    protected function _construct()
    {
        $this->_init('outlook/email');
    }
    public function setConfigObj($config){
        $this->_config = $config;
        return $this;
    }
    public function getConfigObj(){
        return $this->_config;
    }
    public function fetchAttachaments(){
        $apiModel = Mage::getModel('outlook/api');
        $apiModel->setEmailObj($this);
        $allAttachaments=$apiModel->fetchAttachaments();
        return $allAttachaments;
    }
    public function fetchandsaveAttachaments(){
        $allAttachaments=$this->fetchAttachaments();
        foreach($allAttachaments['value'] as $attachament){
            $this->saveAttachament($attachament);
        }
    }
    public function saveAttachament($attachament){
        $attachamentModel = Mage::getModel('outlook/attachament');
        $fileName = $attachament['name'];
        $fileData = base64_decode($attachament['contentBytes']);
        $pathModel = Mage::helper('outlook/path');
        $path = $pathModel->getBasePath();
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filePath = $path . DS . $fileName;
        file_put_contents($filePath, $fileData);
        $data = [
            'filename' => $attachament['name'],
            'path' => $filePath,
            'outlook_id' => $attachament['id'],
            'email_id' => $this->getId(),
        ];
        $attachamentModel->setData($data)->save();
    }

}
?>