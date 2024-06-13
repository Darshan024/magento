<?php

use function PHPSTORM_META\expectedReturnValues;

class Catalog_Block_Admin_Product_List extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/admin/product/list.phtml');
    }
    public function getProduct()
    {
        return Mage::getModel("catalog/product")->getCollection();
    }
    public function getSalesItemData($productId)
    {
        $sales = Mage::getModel("sales/order_item")->getCollection()->addGroupBy('product_id')->addSum('qty', 'sum_qty')->addFieldToFilter('product_id', $productId);
        return $sales->getData();
    }
    public function getCategoryNameById($id)
    {
        $catArr = Mage::getModel('catalog/product')->getCategoryArray();
        if (array_key_exists($id, $catArr)) {
            return $catArr[$id];
        }
        // foreach ($catArr as $key => $value){
        //     if ($id == $key) {
        //         return $value;
        //     }
        //}
    }
}
?>