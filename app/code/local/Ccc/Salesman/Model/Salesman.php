<?php
class Ccc_Salesman_Model_Salesman extends Mage_Core_Model_Abstract
{
    const METRIC_PRODUCT = 'product';
    const METRIC_SHIPPING = 'shipping';
    const METRIC_TAX = 'tax';
    protected function _construct()
    {
        $this->_init('salesman/salesman');
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
    public static function getOptionArray()
    {
        $res = array(
            self::METRIC_PRODUCT => Mage::helper('salesman')->__(self::METRIC_PRODUCT),
            self::METRIC_SHIPPING => Mage::helper('salesman')->__(self::METRIC_SHIPPING),
            self::METRIC_TAX => Mage::helper('salesman')->__(self::METRIC_TAX),
        );
        return $res;
    }
    
}
?>