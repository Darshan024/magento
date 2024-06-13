<?php
class Page_Controller_Index extends Core_Controller_Front_Action
{
    public function IndexAction()
    {
        $layout = $this->getLayout();
        $banner = $layout->createBlock('core/template')
            ->setTemplate('banner/banner.phtml');

        $layout->getChild('head')->addCss('banner/banner.css');
        $layout->getChild('content')
            ->addChild('banner', $banner);
        // print_r($layout->getChild('head'));

        $layout->toHtml();
    }
}
?>