<?php
class Admin_Controller_Banner extends Core_Controller_Admin_Action
{
    public function formAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $layout->getChild('head')->addCss('banner/form.css');

        $productForm = $layout->createBlock('banner/banner');
        $child->addChild('form', $productForm);

        $layout->toHtml();
    }
    
    public function saveAction()
    {
        $banner = $this->getRequest()->getParams('banner');
        if (isset($_POST['submit'])) {
            $imageName = $_FILES['banner_image']['name'];
            $tmp_name = $_FILES['banner_image']['tmp_name'];
            $folder = "media/banner/" . $imageName;
            move_uploaded_file($tmp_name, $folder);

        }
        $banner['banner_image'] = $imageName;
        $_product = Mage::getModel('banner/banner')
            ->setData($banner)
            ->save();
        $this->setRedirect('admin/banner/list');
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParams('id');
        $product = Mage::getModel('banner/banner')
            ->load($id);
        $product->delete();
        $this->setRedirect('admin/banner/list');
    }
    public function listAction()
    {
        $layout = $this->getLayout();
        $layout->getChild('head')->addCss('banner/list.css');
        $child = $layout->getChild('content');
        $productList = $layout->createBlock('banner/list');
        $child->addChild('list', $productList);
        $layout->toHtml();
    }
}
?>