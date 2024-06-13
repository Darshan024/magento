<?php
class Customer_Model_Resource_Address extends Core_Model_Resource_Abstract
{
    protected $_tableName = "";
    protected $_primaryKey = "";
    public function __construct()
    {
        $this->init('customer_address', 'address_id');
    }
}
?>