<?php
class Admin_Controller_Index extends Core_Controller_Admin_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $dashboard = $layout->createBlock('admin/dashboard');
        $child->addChild('dashboard', $dashboard);
        $layout->toHtml();
    }
}

?>