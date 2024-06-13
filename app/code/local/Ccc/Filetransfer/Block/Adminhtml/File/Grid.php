<?php
class Ccc_Filetransfer_Block_Adminhtml_File_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('file');
        $this->setDefaultSort('file_id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('filetransfer/file')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'file_id',
            array(
                'header' => Mage::helper('filetransfer')->__('File Id'),
                'align' => 'left',
                'index' => 'file_id',
            )
        );
        $this->addColumn(
            'config_id',
            array(
                'header' => Mage::helper('filetransfer')->__('Config Id'),
                'align' => 'left',
                'index' => 'config_id',
            )
        );
    
        $this->addColumn(
            'filename',
            array(
                'header' => Mage::helper('filetransfer')->__('Filename'),
                'align' => 'left',
                'index' => 'filename',
            )
        );
        $this->addColumn(
            'received_time',
            array(
                'header' => Mage::helper('filetransfer')->__('Received Time'),
                'index' => 'received_time',
                'type'=>'datetime'
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('filetransfer')->__('Created At'),
                'index' => 'created_at',
                'type'=>'datetime'
            )
        );
        $this->addColumn('action', array(
            'header' => Mage::helper('filemanager')->__('Action'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'Ccc_Filetransfer_Block_Adminhtml_File_Grid_Renderer_Action'
            )
        );
        
        return parent::_prepareColumns();
        
    }
}
?>