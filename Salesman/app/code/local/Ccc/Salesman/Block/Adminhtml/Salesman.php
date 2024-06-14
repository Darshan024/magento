<?php
class Ccc_Salesman_Block_Adminhtml_Salesman extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_salesman';
        $this->_blockGroup = 'salesman';
        $this->_headerText = Mage::helper('salesman')->__('Salesman');
        $this->_addButtonLabel = Mage::helper('salesman')->__('Add New salesman');
        parent::__construct();
    }
}
?>