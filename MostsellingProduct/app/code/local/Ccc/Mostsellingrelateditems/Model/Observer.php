<?php
class Ccc_Mostsellingrelateditems_Model_Observer
{

    public function savemostproduct(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $productData = $product->getData();
        if ($productData['most_selling_item'] == 243) {
            $productId = $productData['entity_id'];
            $collection = Mage::getModel('mostsellingrelateditems/mostsellproduct')->getCollection()->addFieldToFilter('most_selling_product_id', $productId)->getData();
            if (!empty($collection)) {
                $product->setData('has_most_selling_related_items', 247);
            } else {
                $product->setData('has_most_selling_related_items', 248);
            }
        }
    }
    public function savemostsellproduct(Varien_Event_Observer $observer){
        $product = $observer->getProduct();
        $productId = $product->getMostSellingProductId();
        $productModel = Mage::getModel('catalog/product')->load($productId);
        $productModel->setHasMostSellingRelatedItems(247)->save();
    }
}
?>