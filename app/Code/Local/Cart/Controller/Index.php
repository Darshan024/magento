<?php
class Cart_Controller_Index extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $itemList = $layout->createBlock('cart/cart');
        $layout->getChild('head')->addCss('cart/cart.css');
        $child->addChild('itemList', $itemList);
        $layout->toHtml();
    }
}

?>