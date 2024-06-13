<?php
class Sales_Controller_order extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $view = $layout->createBlock('sales/customer_order');
        $layout->getChild('head')->addCss('customer/view.css');
        $child->addChild('view', $view);
        $layout->toHtml();
    }
}