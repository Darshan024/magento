<?php
class Admin_Controller_Catalog_Category extends Core_Controller_Admin_Action
{
    public function formAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $layout->getChild('head')->addCss('catalog/admin/category/form.css');

        $productForm = $layout->createBlock('catalog/admin_category_form');
        $child->addChild('form', $productForm);

        $layout->toHtml();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams('catalog_category');
        $product = Mage::getModel('catalog/category')->setData($data);
        $product->save();
        $this->setRedirect('admin/catalog_category/list');
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParams('id');
        $product = Mage::getModel('catalog/category')
            ->load($id);
        $product->delete();
        $this->setRedirect('admin/catalog_category/list');
    }
    public function listAction()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')->addCss('catalog/admin/category/list.css');
        $child = $layout->getChild('content');
        $categoryList = $layout->createBlock('catalog/admin_category_list');
        $child->addChild('list', $categoryList);
        $layout->toHtml();
    }
}