<?php
class Sales_Block_Admin_Order_Order extends Core_Block_Template{
    public function __construct()
    {
        $this->setTemplate('sales/admin/order/order.phtml');
    }
    public function getOrderData()
    {
        return Mage::getModel('sales/order')->getCollection();
    }
    public function getStatusOption()
    {
        return Mage::getModel('sales/status')->getStatusOtions();
    }
}