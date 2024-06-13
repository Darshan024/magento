<?php
class Customer_Block_Dashboard extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('customer/dashboard.phtml');
    }
    public function getCustomer(){
        $id = Mage::getSingleton('core/session')->get('logged_in_customer_id'); 
        $list =  Mage::getModel("customer/customer")->getCollection()->addFieldToFilter("customer_id",$id);
        return $list->getData();
    }
    // public function setCustomerId($customerId)
    // {
    //     $this->_customerId = $customerId;
    // }
    // public function getCustomerDetails()
    // {
    //     if (!$this->_customerId) {
    //         return null;
    //     }
    //     return Mage::getModel('customer/customer')->load($this->_customerId);
    //     // return Mage::getModel('customer/customer')->getCollection();
    // }
}
?>