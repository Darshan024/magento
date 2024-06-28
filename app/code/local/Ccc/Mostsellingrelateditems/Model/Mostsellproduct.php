<?php
class Ccc_Mostsellingrelateditems_Model_Mostsellproduct extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('mostsellingrelateditems/mostsellproduct');
    }
    public static function getProductArray()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $arr = [];
        foreach ($collection as $product) {
            $arr[$product->getEntityId()] = $product->getSku();
        }
        return $arr;
    }
    protected function _beforeSave()
    {
        parent::_beforeSave();
        if (!$this->getId()) {
            $this->setCreatedAt(now());
        }
        if ($this->getIsDeleted() == 1) {
            $this->setDeletedAt(now());
        }
    }

}

?>