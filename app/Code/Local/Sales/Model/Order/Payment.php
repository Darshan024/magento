<?php

class Sales_Model_Order_Payment extends Core_Model_Abstract
{

    public function init()
    {
        $this->_resourceClass = 'Sales_Model_Resource_Order_Payment';
        $this->_collectionClass = 'Sales_Model_Resource_Collection_Order_Payment';
        $this->_modelClass = 'sales/order_payment';
    }
    public function addOrderPaymentData($salesOrderPaymentData, $orderId)
    {
        $this->setData($salesOrderPaymentData)
            ->removeData('payment_id')
            ->removeData('quote_id')
            ->addData('order_id', $orderId)
            ->save();
        return $this->getId();
    }
    public function getPaymentOtions()
    {
        $paymentOptions = [
            'cod' => 'Cash on Delivery (COD)',
            'creditcard' => 'Credit Card',
            'upi' => 'UPI'
        ];
        return $paymentOptions;
    }
}