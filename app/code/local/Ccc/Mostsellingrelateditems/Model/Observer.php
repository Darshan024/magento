<?php
class Ccc_Mostsellingrelateditems_Model_Observer
{
    public function savemostproduct(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        if ($product->getMostSellingItem() == 243) {
            $productId = $product->getEntityId();
            $collection = Mage::getModel('mostsellingrelateditems/mostsellproduct')->getCollection()->addFieldToFilter('most_selling_product_id', $productId);
            if ($collection->getSize()>0) {
                $product->setHasMostSellingRelatedItems(247);
            } else {
                $product->setHasMostSellingRelatedItems(248);
            }
        }
        return $product;
    }
    public function savemostsellproduct(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $productId = $product->getMostSellingProductId();
        $productModel = Mage::getModel('catalog/product')->load($productId);
        if ($productModel->getMostSellingItem() == 243) {
            $productModel->setHasMostSellingRelatedItems(247)->save();
        }
    }
}
?>