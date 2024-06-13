<?php
class Sales_Model_Status extends Core_Model_Abstract
{

    const DEFAULT_ORDER_ADMIN_STATUS = 1;
    const DEFAULT_ORDER_USER_STATUS = 0;
    const DEFAULT_ORDER_STATUS_TEXT = 'pending';
    const DEFAULT_CANCEL_REQUEST = 'cancel_request';
    const DEFAULT_ORDER_CANCELED = 'canceled';
    const DEFAULT_REQUEST_DECLINED = 'declined';

    public function init()
    {
        $this->_modelClass = 'sales/status';
        $this->_resourceClass = 'Sales_Model_Resource_Status';
        $this->_collectionClass = 'Sales_Model_Resource_Collection_Status';
    }
    public function getStatusOtions()
    {
        $statusOptions = [
            'panding' => 'Pending',
            'shipped' => 'Shipped',
            'canceled' => 'Canceled',
            'declined' => 'Declined',
            'funded' => 'Funded',
            'completed' => 'Completed'
        ];
        return $statusOptions;
    }
}
?>