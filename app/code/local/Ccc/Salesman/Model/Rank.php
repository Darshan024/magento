<?php
class Ccc_Salesman_Model_Rank extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('salesman/rank');
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