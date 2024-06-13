<?php
class Cart_Controller_Checkout extends Core_Controller_Front_Action
{
    protected $_allowedActions = ['login', 'register', 'forgotPassword'];
    public function init()
    {
        if (
            !in_array($this->getRequest()->getActionName(), $this->_allowedActions) &&
            !Mage::getSingleton('core/session')->get('logged_in_customer_id')
        ) {
            Mage::getSingleton('core/session')->set('set_back_url', "cart/checkout/index");
            $this->setRedirect('customer/account/login');
        }
    }
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $checkout = $layout->createBlock('cart/checkout');
        $layout->getChild('head')->addCss('cart/checkout.css');
        $child->addChild('checkout', $checkout);
        $layout->toHtml();  
    }
}
?>