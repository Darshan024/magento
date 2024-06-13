<?php
class Ccc_Productseller_Block_Adminhtml_Catalog_Product_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $sellerModel = Mage::getModel('productseller/seller')->getCollection()->addFieldToFilter('id', $value)->getFirstItem();
        return ($sellerModel->getCompanyName());
    }
}
?>