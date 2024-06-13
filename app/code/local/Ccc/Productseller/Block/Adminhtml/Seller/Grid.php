<?php
class Ccc_Productseller_Block_Adminhtml_Seller_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sellerGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('productseller/seller')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        $this->addColumn(
            'id',
            array(
                'header' => Mage::helper('productseller')->__('Id'),
                'align' => 'left',
                'index' => 'id',
            )
        );
        $this->addColumn(
            'seller_name',
            array(
                'header' => Mage::helper('productseller')->__('Seller Name'),
                'align' => 'left',
                'index' => 'seller_name',
            )
        );
        $this->addColumn(
            'company_name',
            array(
                'header' => Mage::helper('productseller')->__('Company Name'),
                'align' => 'left',
                'index' => 'company_name',
            )
        );
        $this->addColumn(
            'address',
            array(
                'header' => Mage::helper('productseller')->__('Address'),
                'align' => 'left',
                'index' => 'address',
            )
        );
        $this->addColumn(
            'city',
            array(
                'header' => Mage::helper('productseller')->__('City'),
                'align' => 'left',
                'index' => 'city',
            )
        );
        $this->addColumn(
            'state',
            array(
                'header' => Mage::helper('productseller')->__('State'),
                'align' => 'left',
                'index' => 'state',
            )
        );
        $this->addColumn(
            'country',
            array(
                'header' => Mage::helper('productseller')->__('Country'),
                'align' => 'left',
                'index' => 'country',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('productseller')->__('Is Active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    '1' => Mage::helper('productseller')->__('Yes'),
                    '2' => Mage::helper('productseller')->__('No'),
                ),
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('productseller')->__('Created At'),
                'index' => 'created_at',
                'type' => 'datetime'
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header' => Mage::helper('productseller')->__('Updated At'),
                'index' => 'updated_at',
                'type' => 'datetime',
            )
        );
        return parent::_prepareColumns();
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

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('productseller')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('productseller')->__('Status'),
                        'values' =>  array(
                            '1' => Mage::helper('productseller')->__('Yes'),
                            '2' => Mage::helper('productseller')->__('No'),
                        )
                    )
                )
            )
        );

        return $this;
    }

}
?>