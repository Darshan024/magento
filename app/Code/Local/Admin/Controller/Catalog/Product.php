<?php
class Admin_Controller_Catalog_Product extends Core_Controller_Admin_Action
{
    protected $_allowedActions = [];
    public function formAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $layout->getChild('head')->addCss('catalog/admin/product/form.css');

        $productForm = $layout->createBlock('catalog/admin_product_form');
        $child->addChild('form', $productForm);

        $layout->toHtml();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams('catalog_product');

        if (isset($_POST['submit'])) {
            $imageName = $_FILES['image_link']['name'];
            $tmp_name = $_FILES['image_link']['tmp_name'];
            $folder = "media/product/" . $imageName;
            move_uploaded_file($tmp_name, $folder);
        }
        $data['image_link'] = $imageName;
        $product = Mage::getModel('catalog/product')
            ->setData($data);
        $product->save();
        $this->setRedirect('admin/catalog_product/list');
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParams('id');
        $product = Mage::getModel('catalog/product')
            ->load($id);
        $product->delete();
        $this->setRedirect('admin/catalog_product/list');
    }
    public function listAction()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')->addCss('catalog/admin/product/list.css');
        $layout->getChild('head')->addCss('admin/header.css');
        $child = $layout->getChild('content');
        $productList = $layout->createBlock('catalog/admin_product_list');
        $child->addChild('list', $productList);
        $layout->toHtml();
    }
}