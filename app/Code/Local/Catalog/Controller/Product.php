<?php
class Catalog_Controller_Product extends Core_Controller_Front_Action
{
    public function viewAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $layout->getChild('head')->addCss('catalog/product/view.css');
        $view = $layout->createBlock('catalog/product_view');
        $child->addChild('view', $view);
        $layout->toHtml();
    }
}