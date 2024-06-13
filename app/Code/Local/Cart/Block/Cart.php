<?php
class Cart_Block_Cart extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('cart/cart.phtml');
    }
    public function qouteId()
    {
        $quoteId = Mage::getModel('core/session')->get('quote_id');
        if ($quoteId) {
            return $quoteId;
        }
        return 0;
    }
    public function getItemList()
    {
        // return Mage::getSingleton('sales/quote')->getItemCollection();
        $quoteId = Mage::getModel('core/session')->get('quote_id');
        $data = Mage::getModel('sales/quote_item')->getCollection()->addFieldToFilter('quote_id', $quoteId)->getData();
        return $data;
    }
    public function getProductList($id)
    {
        $quoteId = Mage::getModel('catalog/product')->getCollection()->addFieldToFilter('product_id', $id)->getData();
        return $quoteId;
    }
    public function cartGrandTotal()
    {
        $quoteId = Mage::getModel('core/session')->get('quote_id');
        return Mage::getModel('sales/quote')->load($quoteId);
    }
    public function getImageUrl($item)
    {
        return Mage::getBaseUrl('media/product/') . $item->getProduct()->getImageLink();
    }



}