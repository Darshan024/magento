<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesman/salesman')->getCollection();
        /*@var $collection Mage_Cms_Model_Mysql4_Block_Collection*/
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('salesman')->__('Entity Id'),
                'align' => 'left',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'user_id',
            array(
                'header' => Mage::helper('salesman')->__('User Id'),
                'align' => 'left',
                'index' => 'user_id',
            )
        );
        $this->addColumn(
            'metric',
            array(
                'header' => Mage::helper('salesman')->__('Metric'),
                'index' => 'metric',
                'type' => 'options',
                'options' => Ccc_Salesman_Model_Salesman::getOptionArray(),
            )
        );
        $this->addColumn(
            'percentage',
            array(
                'header' => Mage::helper('salesman')->__('Percentage'),
                'index' => 'percentage',
                'renderer'=>'Ccc_Salesman_Block_Adminhtml_Salesman_Grid_Renderer_Action',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('salesman')->__('Created At'),
                'index' => 'created_at',
                'type' => 'datetime'
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header' => Mage::helper('salesman')->__('Updated At'),
                'index' => 'updated_at',
                'type' => 'datetime',
            )
        );

        return parent::_prepareColumns();
    }
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addFieldToFilter('entity_id', $value);
    }

    /**
     * Row click URL
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
        }
    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('salesman')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('salesman')->__('Are you sure you want to delete selected salesmans?')
            )
        );

        Mage::dispatchEvent('banner_adminhtml_banner_grid_prepare_massaction', array('block' => $this));
        return $this;
    }
}




