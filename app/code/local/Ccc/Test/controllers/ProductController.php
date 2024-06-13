<?php
// File: app/code/local/Ccc/Test/controllers/ProductController.php
require_once 'Mage/Catalog/controllers/ProductController.php';
// it is example of the overring the controller this is done by the config.xml file 
class Ccc_Test_ProductController extends Mage_Catalog_ProductController
{
    public function viewAction()
    {
        $block = Mage::getBlockSingleton('catalog/product');
        print_r($block->getProduct());
        // $model = Mage::getModel('catalog/product');
        // print_r($model->getData());
        // die;
        // Get initial data from request
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $productId = (int) $this->getRequest()->getParam('id');
        $specifyOptions = $this->getRequest()->getParam('options');
        // Prepare helper and params
        $viewHelper = Mage::helper('catalog/product_view');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);

        // Render page
        try {
            $viewHelper->prepareAndRender($productId, $this, $params);
        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store']) && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                } elseif (!$this->getResponse()->isRedirect()) {
                    $this->_forward('noRoute');
                }
            } else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
                     
    }
    
}
