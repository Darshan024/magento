<?php
class Ccc_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerBlockGrid');
        $this->setTemplate('banner/grid.phtml');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
    }

    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();
        /*@var $collection Mage_Cms_Model_Mysql4_Block_Collection*/
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        if (Mage::getSingleton('admin/session')->isAllowed('banner/column/banner_id')) {
            $this->addColumn(
                'banner_id',
                array(
                    'header' => Mage::helper('banner')->__('Banner Id'),
                    'align' => 'left',
                    'index' => 'banner_id',
                )
            );
        }
        if (Mage::getSingleton('admin/session')->isAllowed('banner/column/banner_image')) {
            $this->addColumn(
                'banner_image',
                array(
                    'header' => Mage::helper('banner')->__('Banner Image'),
                    'align' => 'left',
                    'index' => 'banner_image',
                    'renderer' => 'Ccc_Banner_Block_Adminhtml_Banner_Grid_Renderer_Action'
                )
            );
        }
        if (Mage::getSingleton('admin/session')->isAllowed('banner/column/banner_status')) {
            $this->addColumn(
                'status',
                array(
                    'header' => Mage::helper('banner')->__('Status'),
                    'index' => 'status',
                    'type' => 'options',
                    'options' => array(
                        '1' => Mage::helper('banner')->__('Enabled'),
                        '2' => Mage::helper('banner')->__('Disabled'),
                    ),
                )
            );
        }
        if (Mage::getSingleton('admin/session')->isAllowed('banner/column/banner_show')) {
            $this->addColumn(
                'show_on',
                array(
                    'header' => Mage::helper('banner')->__('Show On'),
                    'index' => 'show_on',
                    'type' => 'text',
                    'editable' => true,
                )
            );
        }
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

        $this->getCollection()->addFieldToFilter('banner_id', $value);
    }

    /**
     * Row click URL
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        // if (Mage::getSingleton('admin/session')->isAllowed('banner/edit')) {
            return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
        // }
    }
    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banner_id'); // Change to 'banner_id'
        if (Mage::getSingleton('admin/session')->isAllowed('banner/delete')) {
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label' => Mage::helper('banner')->__('Delete'),
                    'url' => $this->getUrl('*/*/massDelete'),
                    'confirm' => Mage::helper('banner')->__('Are you sure you want to delete selected banners?')
                )
            );
        }
        $statuses = Mage::getSingleton('banner/status')->getOptionArray();
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('banner')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('banner')->__('Status'),
                        'values' => $statuses
                    )
                )
            )
        );
        Mage::dispatchEvent('banner_adminhtml_banner_grid_prepare_massaction', array('banner' => $this));
        return $this;
    }

}




