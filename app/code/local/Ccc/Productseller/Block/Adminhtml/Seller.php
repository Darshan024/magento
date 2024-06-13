<?php
class Ccc_Productseller_Block_Adminhtml_Seller extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_seller';
        $this->_blockGroup = 'productseller';
        $this->_headerText = Mage::helper('productseller')->__('Seller');
        $this->_addButtonLabel = Mage::helper('productseller')->__('Add New Seller');
        parent::__construct();
    }
}
?>