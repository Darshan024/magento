<?php
class Catalog_Block_Category_View extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("catalog/category/view.phtml");
    }
    public function getProductData()
    {
        $id = $this->getRequest()->getParams('id');
        $priceFilter = $this->getRequest()->getParams('price');
        $collection = Mage::getModel("catalog/product")->getCollection();
        if ($id) {
            $collection->addFieldToFilter('category_id', $id);
        }
        if ($priceFilter) {
            switch ($priceFilter) {
                case '1':
                    $collection->addFieldToFilter('price', ['between' => [0, 20]]);
                    break;
                case '2':
                    $collection->addFieldToFilter('price', ['between' => [20, 40]]);
                    break;
                case '3':
                    $collection->addFieldToFilter('price', ['gt' => 40]);
                    break;
                default:
                    break;
            }
        }
        return $collection->getData();
    }
    public function showPrice()
    {
        $price = ['0-20' => '1', '20-40' => '2', '40 Above' => '3'];
        return $price;
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