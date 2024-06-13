<?php
class Customer_Model_Resource_Customer extends Core_Model_Resource_Abstract
{
    protected $_tableName = "";
    protected $_primaryKey = "";
 

    //Above part is abstract
    public function __construct()
    {
        $this->init('customer', 'customer_id');
    }
}
?>