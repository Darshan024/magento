<?php
class Ccc_Salesman_Model_Resource_Ordercommision extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('salesman/ordercommision', 'entity_id');
    }
}
?>