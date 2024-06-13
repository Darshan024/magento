<?php
class Page_Block_Header extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('page/header.phtml');
    }
    public function userLogin()
    {
        return Mage::getSingleton('core/session')->get('logged_in_customer_id');
    }
    public function getCustomerName()
    {
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        return Mage::getModel('customer/customer')->load($customerId)->getFirstName();
    }
    public function getCatalogCategory()
    {
        return Mage::getModel('catalog/category')->getCollection()->getData();
    }
}
?>