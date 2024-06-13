<?php
class Sales_Block_Customer_Order extends Core_Block_Template{
    public function __construct(){
        $this->setTemplate('sales/customer_order.phtml');
    }
    public function getOrderData()
    {
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        return Mage::getModel('sales/order')->getCollection()->addFieldToFilter('customer_id', $customerId);
    }
    public function getOrderItemData($orderId)
    {
        // $orderId = $this->getOrderData()->getData()->getOrderId();
        // print_r($orderId);
        // die;
        return Mage::getModel('sales/order_item')->getCollection()->addFieldToFilter('order_id', $orderId);
    }
    public function getProductData($productId)
    {
        // $productId = $this->getOrderItemData()[0]->getOrderId();
        // print_r($productId);
        // die;
        return Mage::getModel('catalog/product')->getCollection()->addFieldToFilter('product_id', $productId);
    }
    public function getAddressData()
    {
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        return Mage::getModel('sales/order_customer')->getCollection()->addFieldToFilter('customer_id', $customerId)->getFirstItem();
    }
}