<?php

class Sales_Model_Quote_Customer extends Core_Model_Abstract
{

    public function init()
    {
        $this->_resourceClass = 'Sales_Model_Resource_Quote_Customer';
        $this->_collectionClass = 'Sales_Model_Resource_Collection_Quote_Customer';
        $this->_modelClass = 'sales/quote_customer';
    }

    public function addCustomerAddress(Sales_Model_Quote $quote, $request)
    {
        // print_r($request);
        // die;
        $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        $this->setData($request);
        $this->addData('quote_id', $quote->getId());
        $this->addData('customer_id', $customerId);
        $this->addData('email', $this->getCustomerEmail($customerId));
        $this->save();

        return $this;
    }
    public function getCustomerEmail($customerId){
        return Mage::getModel('customer/customer')->load($customerId)->getCustomerEmail();
    }
}