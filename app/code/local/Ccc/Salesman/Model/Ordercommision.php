<?php
class Ccc_Salesman_Model_Ordercommision extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('salesman/ordercommision');
    }
    protected function _beforeSave()
    {
        parent::_beforeSave();
        if (!$this->getId()) {
            $this->setCreatedAt(now());
        } else {
            $this->setUpdatedAt(date('Y-m-d H:i:s'));
        }
        return $this;
    }
}
?>