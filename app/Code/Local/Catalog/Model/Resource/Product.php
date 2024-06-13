<?php
class Catalog_Model_Resource_Product extends Core_Model_Resource_Abstract
{
    protected $_tableName = "";
    protected $_primaryKey = "";

    //Above part is abstract
    public function __construct()
    {
        $this->init('catalog_product', 'product_id');
    }

}
?>