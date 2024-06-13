<?php
class Sales_Block_Admin_Order_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('sales/admin/order/view.phtml');
    }
    public function getOrderId()
    {
        return $this->getRequest()->getParams('id');
    }
    public function getOrderData()
    {
        $orderId = $this->getOrderId();
        return Mage::getModel('sales/order')->load($orderId);
    }
    public function getCustomerData($customerId)
    {
        return Mage::getModel('customer/customer')->load($customerId);
    }
    public function getOrderItemData($orderId)
    {
        return Mage::getModel('sales/order_item')->getCollection()->addFieldToFilter('order_id', $orderId)->getData();
    }
    public function getProductData($productId)
    {
        return Mage::getModel('catalog/product')->load($productId);
    }
    public function getShippingData($shippingId)
    {
        return Mage::getModel('sales/order_shipping')->load($shippingId);
    }
    public function getPaymentData($paymentId)
    {
        return Mage::getModel('sales/order_payment')->load($paymentId);
    }
    public function getHistoryData($orderId)
    {
        return Mage::getModel('sales/order_history')->getCollection()->addFieldToFilter('order_id', $orderId);
    }
}