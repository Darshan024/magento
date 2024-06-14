<?php 

class Ccc_Outlook_EmailController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $configId = $this->getRequest()->getParam('state');
        $configModel = Mage::getModel('outlook/configuration')->load($configId);
        $apiModel = Mage::getModel('outlook/api');
        $accessToken = $apiModel->saveAccessToken($configModel);
        $configModel->setData('access_token', $accessToken)->save();
    }
}