<?php
class Ccc_Filetransfer_Block_Adminhtml_Part_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('part');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('filetransfer/part')->getCollection();
        $collection->getSelect()->joinLeft(
            array('newpart' => $collection->getTable('filetransfer/newpart')),
            'main_table.entity_id = newpart.part_id',
            array('newpart.new_part_id','newpart.new_part_date')
        );
        $collection->getSelect()->joinLeft(
            array('dispart' => $collection->getTable('filetransfer/dispart')),
            'main_table.entity_id = dispart.part_id',
            array('dispart.dis_part_id','dispart.dis_part_date')
        );
        $collection->addFilterToMap('part_number', 'main_table.part_number');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('filetransfer')->__('Entity Id'),
                'align' => 'left',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'part_number',
            array(
                'header' => Mage::helper('filetransfer')->__('Part Number'),
                'align' => 'left',
                'index' => 'part_number',
            )
        );

        $this->addColumn(
            'depth',
            array(
                'header' => Mage::helper('filetransfer')->__('Depth'),
                'align' => 'left',
                'index' => 'depth',
            )
        );
        $this->addColumn(
            'length',
            array(
                'header' => Mage::helper('filetransfer')->__('Length'),
                'index' => 'length',
            )
        );
        $this->addColumn(
            'weight',
            array(
                'header' => Mage::helper('filetransfer')->__('Weight'),
                'index' => 'weight',
            )
        );
        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('filemanager')->__('Status'),
                'width' => '100px',
                'renderer'=>'Ccc_Filetransfer_Block_Adminhtml_Part_Grid_Renderer_Action',
                'index' => 'status',
            )
        );
        $this->addColumn(
            'date',
            array(
                'header' => Mage::helper('filemanager')->__('Date'),
                'width' => '100px',
                'renderer'=>'Ccc_Filetransfer_Block_Adminhtml_Part_Grid_Renderer_Date',
                'filter' => false,
                'index' => 'date',
            )
        );

        return parent::_prepareColumns();

    }
}
?>