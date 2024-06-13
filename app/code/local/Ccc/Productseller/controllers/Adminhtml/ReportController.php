<?php
class Ccc_Productseller_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customer');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('customer'))->_title($this->__('productseller'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function griddataAction()
    {
        $block = $this->getLayout()->createBlock('productseller/adminhtml_report_grid');
        $requestData = $this->getRequest()->getParams();
        $data = $block->getSellerGrid($requestData);
        $this->getResponse()->setBody($data);
    }
    public function saveAction()
    {
        $block = $this->getLayout()->createBlock('productseller/adminhtml_report_grid');
        $requestData = $this->getRequest()->getParams();
        $data = $block->saveProductAttribute($requestData);
        $this->getResponse()->setBody($data);
    }
   

    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        
        switch ($action) {
            case 'index':
                $aclResource = 'customer/seller_report/index';
                break;
            default:
                $aclResource = 'customer/seller_report';
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
    public function massStatusAction()
    {
        $Ids = $this->getRequest()->getParam('id');
        $seller = $this->getRequest()->getParam('seller');
        if (!is_array($Ids)) {
            $Ids = array($Ids);
        }
        try {
            foreach ($Ids as $Id) {
                $model = Mage::getModel('catalog/product')->load($Id);
                $model->setData('seller_id', $seller);
                $model->save();
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }
}
?>
