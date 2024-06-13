<?php
class Customer_Block_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('customer/view.phtml');
    }
    public function getOrderData()
    {
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        return Mage::getModel('sales/order')->getCollection()->addFieldToFilter('customer_id', $customerId);
    }
    public function getOrderItemData($orderId)
    {
        return Mage::getModel('sales/order_item')->getCollection()->addFieldToFilter('order_id', $orderId);
    }
    public function getProductData($productId)
    {
        return Mage::getModel('catalog/product')->getCollection()->addFieldToFilter('product_id', $productId);
    }
    public function getAddressData()
    {
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        return Mage::getModel('sales/order_customer')->getCollection()->addFieldToFilter('customer_id', $customerId)->getFirstItem();
    }
    public function imageLink($imageLink)
    {
        return Mage::getBaseUrl('media/product/') . $imageLink;
    }
}