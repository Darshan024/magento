<?php
class Ccc_Mostsellingrelateditems_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    public function ajaxAction(){
        $this->getResponse()->setBody($this->getLayout()->createBlock('Mostsellingrelateditems/adminhtml_view')->toHtml());
    }
    public function viewgrid(){
        $this->getResponse()->setBody($this->getLayout()->createBlock('Mostsellingrelateditems/adminhtml_catalog_product_grid')->toHtml());
    }
}
?>