<?php
class Ccc_Productseller_Model_Resource_Seller_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('productseller/seller');
    }
}
?>