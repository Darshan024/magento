<?php
class Ccc_Filetransfer_Block_Adminhtml_Part extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_part';
        $this->_blockGroup = 'filetransfer';
        $this->_headerText = Mage::helper('filetransfer')->__('Part');
        parent::__construct();
    }
}
?>