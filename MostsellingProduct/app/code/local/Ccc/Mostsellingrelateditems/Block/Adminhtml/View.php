<?php
class Ccc_Mostsellingrelateditems_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Container
{

    public function __construct()
    {
        $this->setTemplate('mostsellingrelateditems/view/view.phtml');
        parent::__construct();
    }
    public function getProductArray(){
        $collection = Mage::getModel('catalog/product')->getCollection();
        $arr=[];
        foreach ($collection as $product) {
            $arr[$product->getEntityId()] = $product->getEntityId();
        }
        return $arr;
    }
    public function getProductData(){
        $produtData = [];
        if($this->getRequest()->getParam('isAjax')=='true'){
            $productId = $this->getRequest()->getParam('productId');
            $produtData = Mage::getModel('catalog/product')->load($productId);
            return $produtData->getData();
        }
        return $produtData;
    }
    public function isMostSellingItem(){
        if($this->getRequest()->getParam('isAjax')=='true'){
            $productId = $this->getRequest()->getParam('productId');
            $productModel = Mage::getModel('mostsellingrelateditems/mostsellproduct')->getCollection()
                ->addFieldToFilter('most_selling_product_id', $productId)
                ->addFieldToFilter('is_deleted', 2)->getData();
            if(!empty($productModel)){
                return true;
            }
            return false;
        }
        
    }
}
?>
