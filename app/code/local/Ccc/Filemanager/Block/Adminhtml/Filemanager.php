<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_filemanager';
        $this->_blockGroup = 'filemanager';
        $this->_headerText = Mage::helper('filemanager')->__('Filemanager');
        parent::__construct();
        $this->removeButton('add');
    }
    public function getPaths()
    {
        $paths = Mage::getStoreConfig("filemanager/frontend/file_path");
        $paths = preg_split('/\s+/', $paths);
        return $paths;
    }
}
?>