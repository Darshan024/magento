<?php
class Catalog_Block_Admin_Product_Form extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/admin/product/form.phtml');
    }
    public function getProductForm()
    {
        $productModel = Mage::getModel('catalog/product');
        $id = $this->getRequest()->getParams('id');
        if ($id != '') {

            $productModel->load($id);
        }
        return $productModel;
    }
    
    public function  getCategoryList(){
        return Mage::getModel("catalog/category")->getCollection();
    }
}
?>