<?php
class Sales_Model_Quote_Item extends Core_Model_Abstract
{
    protected $_product = '';
    public function init()
    {
        $this->_resourceClass = 'Sales_Model_Resource_Quote_Item';
        $this->_collectionClass = 'Sales_Model_Resource_Collection_Quote_Item';
        $this->_modelClass = 'sales/quote_item';
    }
    public function getProduct()
    {
        if ($this->_product) {
            return $this->_product;
        }
        $this->_product = Mage::getModel('catalog/product')->load($this->getProductId());
        return $this->_product;
    }

    protected function _beforeSave()
    {
        if ($this->getProductId()) {
            $price = $this->getProduct()->getPrice();
            $this->addData('price', $price);
            $this->addData('row_total', $price * $this->getQty());
        } else {
        }
    }


    public function addItem(Sales_Model_Quote $quote, $productId, $qty)
    {
        $item = $this->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->addFieldToFilter('quote_id', $quote->getId())
            ->getFirstItem();
        if ($item) {
            $qty = $qty + $item->getQty();
        }
        $this->setData(
            [
                'quote_id' => $quote->getId(),
                'product_id' => $productId,
                'qty' => $qty
            ]
        );
        if ($item) {
            $this->setId($item->getId());
        }
        $this->save();
        return $this;
    }
    public function removeItem(Sales_Model_Quote $quote, $itemId)
    {
        $item = $this->getCollection()
            ->addFieldToFilter('item_id', $itemId)
            ->addFieldToFilter('quote_id', $quote->getId())
            ->getFirstItem();
        $this->setData(
            [
                'quote_id' => $quote->getId(),
                'item_id' => $itemId
            ]
        );
        $this->delete();
        return $this;
    }
    public function updateItem(Sales_Model_Quote $quote, $itemId, $productId, $qty)
    {
        $item = $this->getCollection()
            ->addFieldToFilter('item_id', $itemId)
            ->addFieldToFilter('quote_id', $quote->getId())
            ->addFieldToFilter('product_id', $productId)
            ->getFirstItem();
        $this->setData(
            [
                'quote_id' => $quote->getId(),
                'item_id' => $itemId,
                'product_id' => $productId,
                'qty' => $qty
            ]
        );
        if ($item) {
            $this->setId($item->getId());
        }
        $this->save();
        return $this;
    }
}

