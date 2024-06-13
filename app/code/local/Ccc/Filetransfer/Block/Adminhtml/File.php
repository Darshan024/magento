<?php
class Ccc_Filetransfer_Block_Adminhtml_File extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_file';
        $this->_blockGroup = 'filetransfer';
        $this->_headerText = Mage::helper('filetransfer')->__('File');
        parent::__construct();
    }
}

?>