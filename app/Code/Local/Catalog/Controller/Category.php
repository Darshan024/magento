<?php

class Catalog_Controller_Category extends Core_Controller_Front_Action
{
    public function viewAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $layout->getChild('head')->addCss('catalog/category/view.css');
        $layout->getChild('head')->addJs('category/view.js');
        $view = $layout->createBlock('catalog/category_view');
        $child->addChild('view', $view);
        $layout->toHtml();
    }
}





