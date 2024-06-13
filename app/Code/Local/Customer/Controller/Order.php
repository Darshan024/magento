<?php
class Customer_Controller_Order extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $orderPlace = $layout->createBlock('customer/order');
        $layout->getChild('head')->addCss('customer/order.css');
        $child->addChild('orderPlace', $orderPlace);
        $layout->toHtml();
    }
}