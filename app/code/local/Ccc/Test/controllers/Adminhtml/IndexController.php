<?php
class Ccc_Test_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('test');
        return $this;
    }
    public function indexAction()
    {
        $block = new Mage_Core_Block_Text();
        // $block->setText("Hello World");
        echo $block->toHtml();
    }
}
?>