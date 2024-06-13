<?php
class Customer_Controller_View extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $view = $layout->createBlock('customer/view');
        $layout->getChild('head')->addCss('customer/view.css');
        $child->addChild('view', $view);
        $layout->toHtml();
    }
    public function cancelAction()
    {
        $orderId = $this->getRequest()->getParams('id');
        $defaulyCancelRequest = Sales_Model_Status::DEFAULT_CANCEL_REQUEST;
        $data = [
            'order_id' => $orderId,
            'status' => $defaulyCancelRequest
        ];
        Mage::getModel('sales/order_history')->updateHistory($data, 0);
        Mage::getModel('sales/order')->setData($data)->save();
        $this->setRedirect('customer/view');
    }
}