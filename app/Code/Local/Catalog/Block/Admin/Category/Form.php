<?php
class Catalog_Block_Admin_Category_Form extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/admin/category/form.phtml');
    }
    public function getCategoryForm()
    {
        $categoryModel = Mage::getModel('catalog/category');
        $id = $this->getRequest()->getParams('id');
        if ($id != '') {

            $categoryModel->load($id);
        }
        return $categoryModel;
    }

}

?>