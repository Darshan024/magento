<?php

class Ccc_Productseller_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ReportGrid');
        $this->setTemplate('productseller/grid.phtml');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id')
            ->addAttributeToSelect('seller_id');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'align' => 'index',
                'type' => 'number',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'seller_id',
            array(
                'header' => Mage::helper('catalog')->__('Seller Id'),
                'width' => '50px',
                'index' => 'seller_id',
            )
        );
        $this->addColumn(
            'name',
            array(
                'header' => Mage::helper('catalog')->__('Name'),
                'index' => 'name',
            )
        );
        return parent::_prepareColumns();
    }
    public function getSellers()
    {
        $a = [];
        $collection = Mage::getModel('productseller/seller')->getCollection();
        foreach ($collection->getData() as $data) {
            $a[$data['id']] = $data['seller_name'];
        }
        return $a;
    }
    public function getSellerGrid($data)
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id')
            ->addAttributeToSelect('seller_id');
        $collection->addFieldToFilter('seller_id', $data['seller']);
        $data = $collection->getData();
        return json_encode($data);
    }
    public function saveProductAttribute($data)
    {
        $ids = explode(',', $data['product_id']);
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $model = Mage::getModel('catalog/product')->load($id);
                $model->setData('seller_id', $data['seller']);
                $model->save();
            }
        }
    }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->addItem(
            'seller',
            array(
                'label' => Mage::helper('productseller')->__('Assign To Seller'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'seller',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('banner')->__('Status'),
                        'values' => $this->getSellers(),
                    )
                )

            )
        );
        return $this;
    }
    public function getSellerData()
    {
        $seller = $this->getRequest()->getParam('seller');
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id')
            ->addAttributeToSelect('seller_id');
        $collection->addFieldToFilter('seller_id', $seller);
        $data = $collection->getData();
        return $data;
    }
}
?>