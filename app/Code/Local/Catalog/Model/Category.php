<?php
class Catalog_Model_Category extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClass = 'Catalog_Model_Resource_Category';
        $this->_collectionClass = 'Catalog_Model_Resource_Collection_Category';
        $this->_modelClass = 'catalog/category';
    }
    public function getStetus()
    {
        $mapping = [
            1 => "Enabled",
            0 => "Disabled"
        ];
        if (isset($this->_data['status'])) {
            return $mapping[$this->_data['status']];

        }
    }
}