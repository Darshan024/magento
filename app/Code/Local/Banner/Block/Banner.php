<?php
class Banner_Block_Banner extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('banner/form.phtml');
    }
    public function getBannerForm()
    {
        $bannerModel = Mage::getModel('banner/banner');
        $id = $this->getRequest()->getParams('id');
        if ($id != '') {
            $bannerModel->load($id);
        }
        return $bannerModel;
    }
}
?>