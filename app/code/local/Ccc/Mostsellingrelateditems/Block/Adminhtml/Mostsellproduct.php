<?php
class Ccc_Mostsellingrelateditems_Block_Adminhtml_Mostsellproduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_mostsellproduct';
        $this->_blockGroup = 'Mostsellingrelateditems';
        $this->_headerText = Mage::helper('Mostsellingrelateditems')->__('Most Sell Product');
        parent::__construct();
    }
}
?>