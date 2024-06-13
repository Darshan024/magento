<?php
class Cart_Block_Checkout extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('cart/checkout.phtml');
    }
    public function getCustomerAddress()
    {
        $cusomerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        return Mage::getModel('customer/address')->getCollection()->addFieldToFilter('customer_id', $cusomerId);
    }
    public function getPaymentOption()
    {
        return Mage::getModel('sales/order_payment')->getPaymentOtions();
    }
    public function getShippingOption()
    {
        return Mage::getModel('sales/order_shipping')->getShippingOtions();
    }
    public function getCountry()
    {
        $mapping =  [
            0 => "Australia",
            1 => "Bangladesh",
            2 => "Belize",
            3 => "Benin",
            4 => "Brazil",
            5 => "Canada",
            6 => "China",
            7 => "France",
            8 => "Germany",
            9 => "India"
          ];
        if (isset($this->_data['status'])) {
            return $mapping[$this->_data['status']];
        }
    }
    public function getRegion()
    {
        $mapping = [
            1 => "Enabled",
            0 => "Disabled"
        ];
        if (isset($this->_data['status'])) {
            return $mapping[$this->_data['status']];
        }
    }
}