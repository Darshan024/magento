<?php
class Ccc_Filetransfer_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('filetransfer');
        $this->setDefaultSort('config_id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('filetransfer/configuration')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
            $this->addColumn(
                'config_id',
                array(
                    'header' => Mage::helper('filetransfer')->__('Config Id'),
                    'align' => 'left',
                    'index' => 'config_id',
                )
            );
        
            $this->addColumn(
                'username',
                array(
                    'header' => Mage::helper('filetransfer')->__('Username'),
                    'align' => 'left',
                    'index' => 'username',
                )
            );
            $this->addColumn(
                'password',
                array(
                    'header' => Mage::helper('filetransfer')->__('Password'),
                    'index' => 'password',
                )
            );
            $this->addColumn(
                'host',
                array(
                    'header' => Mage::helper('filetransfer')->__('Host'),
                    'index' => 'host',
                )
            );
            $this->addColumn(
                'port',
                array(
                    'header' => Mage::helper('filetransfer')->__('Port'),
                    'index' => 'port',
                )
            );
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('config_id' => $row->getId()));
    }
}
?>