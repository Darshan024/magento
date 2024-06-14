<?php
class Ccc_Filemanager_Adminhtml_FilemanagerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('filemanager');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Filemanager'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function deleteAction(){
        $filepath = $this->getRequest()->getParam('filepath');
        if(file_exists($filepath)){
            unlink($filepath);
        }
        $this->_redirect('*/*/index');
    }  
    public function downloadAction(){
        $filepath = $this->getRequest()->getParam('filepath');
        if(file_exists($filepath)) {
            $this->_prepareDownloadResponse(basename($filepath),file_get_contents($filepath));
        }
    } 
    public function gridAction(){
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('filemanager/adminhtml_filemanager_grid')->toHtml()
        );
    }
    public function saveAction(){
        $oldName = $this->getRequest()->getParam('basename');
        $value = $this->getRequest()->getParam('value');
        $path = $this->getRequest()->getParam('path');
        $newPath = str_replace($oldName, $value,$path);
        if(!file_exists($newPath)){
            rename($path, $newPath);
        }
    }
}
?>