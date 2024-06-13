<?php
class Catalog_Model_Product extends Core_Model_Abstract
{
    protected $_data = [];
    public function init()
    {
        $this->_resourceClass = 'Catalog_Model_Resource_Product';
        $this->_collectionClass = 'Catalog_Model_Resource_Collection_Product';
        $this->_modelClass = 'catalog/product';
    }
    public function getCategoryArray()
    {
        $category = Mage::getModel('catalog/category')->getCollection();
        $catData = $category->getData();
        // print_r($catData);
        // die;
        if (isset ($this->_data)) {
            foreach ($category->getData() as $catData) {
                $this->_data[$catData->getCategoryId()] = $catData->getCategoryName();
            }
        }
        // print_r($this->_data);
        return $this->_data;
    }
    public function getStetus()
    {
        $mapping = [
            1 => "Enabled",
            0 => "Disabled"
        ];
        if (isset ($this->_data['status'])) {
            return $mapping[$this->_data['status']];
        }
    }
}
?>