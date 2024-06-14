<?php
class Ccc_Salesman_Model_Product extends Mage_Catalog_Model_Product
{
    public function getNameForDescription($id)
    {
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getName();
    }
    public function getAttributeIsLowSellProduct($id)
    {
        $product = Mage::getModel('catalog/product')->load($id);
        return $product->getAttributeText('is_low_seller_product');
    }
}
?>