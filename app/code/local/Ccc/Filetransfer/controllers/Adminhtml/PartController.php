<?php
class Ccc_Filetransfer_Adminhtml_PartController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('filetransfer');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Filetransfer'));
        $this->_initAction();
        $this->renderLayout();
    }
}
?>