<?php
class Xyz_Test_Model_Observer
{
    public function addCustomProductAttributes(Varien_Event_Observer $observer)
    {
        $item = $observer->getEvent()->getQuoteItem();
        $product = $observer->getEvent()->getProduct();
        Mage::log($product->getTest(),null,'vivek.log',true);
        if ($product->getTest()) {
            $item->setData('test', $product->getTest());
        }
    }
}
