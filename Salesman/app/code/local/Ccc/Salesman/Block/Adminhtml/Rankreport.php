<?php
class Ccc_Salesman_Block_Adminhtml_Rankreport extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct()
    {
        $this->_controller = 'adminhtml_rankreport';
        $this->_blockGroup = 'salesman';
        $this->_headerText = Mage::helper('salesman')->__('Rank Report');
        parent::__construct();
        $this->removeButton('add');
    }
}
?>