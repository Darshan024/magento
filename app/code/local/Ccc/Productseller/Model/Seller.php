<?php
class Ccc_Productseller_Model_Seller extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('productseller/seller');
    }
    protected function _beforeSave()
    {
        parent::_beforeSave();
        if (!$this->getId()) {
            $this->setCreatedAt(date('Y-m-d H:i:s'));
        } else {
            $this->setUpdatedAt(date('Y-m-d H:i:s'));
        }
        return $this;
    }
}
?>