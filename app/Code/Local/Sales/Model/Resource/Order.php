<?php
class Sales_Model_Resource_Order extends Core_Model_Resource_Abstract
{
    protected $_primaryKey = '';
    protected $_tableName = '';
    public function __construct()
    {
        $this->init('sales_order', 'order_id');
    }
}
?>