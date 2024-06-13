<?php
class Sales_Model_Order_History extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClass = 'Sales_Model_Resource_Order_History';
        $this->_collectionClass = 'Sales_Model_Resource_Collection_Order_History';
        $this->_modelClass = 'sales/order_history';
    }
    public function addHistoryData($orderId)
    {
        $defaultUserStatus = Sales_Model_Status::DEFAULT_ORDER_USER_STATUS;
        $defaultStatusText = Sales_Model_Status::DEFAULT_ORDER_STATUS_TEXT;
        $this->setData([
            'order_id' => $orderId,
            'from_status' => $defaultStatusText,
            'to_status' => $defaultStatusText,
            'action_by' => $defaultUserStatus
        ])->save();
        return $this;
    }
    public function updateHistory($order, $actionBy)
    {
        $data = [
            'order_id' => $order['order_id'],
            'from_status' => $this->getFromStatusField($order['order_id']),
            'to_status' => $order['status'],
            'action_by' => $actionBy
        ];
        // print_r($data);die;
        $this->setData($data)->save();
        return $this;
    }
    public function getFromStatusField($orderId)
    {
        $order = Mage::getModel('sales/order')->getCollection()->addFieldToFilter('order_id', $orderId)->getFirstItem();
        $status = $order->getStatus();
        return $status;
    }
}