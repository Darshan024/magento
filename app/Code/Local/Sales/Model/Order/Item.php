<?php
class Sales_Model_Order_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClass = 'Sales_Model_Resource_Order_Item';
        $this->_collectionClass = 'Sales_Model_Resource_Collection_Order_Item';
        $this->_modelClass = 'sales/order_item';
    }
    public function addOrderItem(Sales_Model_Quote_item $orderData, $orderId)
    {
        $productData = Mage::getModel('catalog/product')->load($orderData->getProductId());
        $this->setData($orderData->getData())
            ->removeData('quote_id')
            ->removeData('item_id')
            ->addData('product_name', $productData->getName())
            ->addData('product_color', $productData->getColor())
            ->addData('order_id', $orderId)
            ->save();
        $inventory = (int) $productData->getInventory() - (int) $this->getQty();
        $productData->addData('inventory', $inventory)->save();
        return $this;
    }
}