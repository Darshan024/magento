<?php
class Xyz_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo '<pre>';
        $a = Mage::getModel('test/abc');
        var_dump(get_class($a));
        $b = Mage::getBlockSingleton('test/abc');
        print_r($b);
    }
}