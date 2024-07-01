<?php
class Ccc_Mostsellingrelateditems_Block_Adminhtml_Mostsellproduct_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('mostsellproduct');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mostsellingrelateditems/mostsellproduct')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
            $this->addColumn(
                'id',
                array(
                    'header' => Mage::helper('Mostsellingrelateditems')->__('ID'),
                    'align' => 'left',
                    'index' => 'id',
                )
            );
        
            $this->addColumn(
                'most_selling_product_id',
                array(
                    'header' => Mage::helper('Mostsellingrelateditems')->__('Most selling product Id'),
                    'align' => 'left',
                    'index' => 'most_selling_product_id',
                )
            );
            $this->addColumn(
                'related_product_id',
                array(
                    'header' => Mage::helper('Mostsellingrelateditems')->__('Related Product Id'),
                    'index' => 'related_product_id',
                )
            );
            $this->addColumn(
                'created_at',
                array(
                    'header' => Mage::helper('Mostsellingrelateditems')->__('created_at'),
                    'index' => 'created_at',
                )
            );
            $this->addColumn(
                'is_deleted',
                array(
                    'header' => Mage::helper('Mostsellingrelateditems')->__('Is Deleted'),
                    'index' => 'is_deleted',
                    'options' =>array(
                        '1' => Mage::helper('Mostsellingrelateditems')->__('Yes'),
                        '2' => Mage::helper('Mostsellingrelateditems')->__('No'),
                    )
                )
            );
            $this->addColumn(
                'deleted_at',
                array(
                    'header' => Mage::helper('Mostsellingrelateditems')->__('Deleted At'),
                    'index' => 'deleted_at',
                )
            );
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('Mostsellingrelateditems')->__('Change Deleted'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('Mostsellingrelateditems')->__('Status'),
                        'values' =>  array(
                            '1' => Mage::helper('Mostsellingrelateditems')->__('Yes'),
                            '2' => Mage::helper('Mostsellingrelateditems')->__('No'),
                        )
                    )
                )
            )
        );

        return $this;
    }
}
?>
