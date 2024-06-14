<?php
class Ccc_Salesman_Adminhtml_OrdercommisionController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('salesman');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Salesman'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function gridAction()
    { 
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('salesman/adminhtml_report/grid')->getGridHtml()
        );
    }
    public function rankreportAction(){
        $this->_title($this->__('Salesman'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function rankreportajaxAction()
    { 
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('salesman/adminhtml_rankreport/grid')->getGridHtml()
        );
    }
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'salesman/salesman_commission/index';
                break;
            case 'select_salesman':
                $aclResource = 'salesman/salesman_commission/select_salesman';
                break;
            default:
                $aclResource = 'salesman/salesman_commission';
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
}
?>