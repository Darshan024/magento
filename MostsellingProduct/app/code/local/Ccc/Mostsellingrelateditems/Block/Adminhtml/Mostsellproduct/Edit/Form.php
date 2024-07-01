<?php
class Ccc_Mostsellingrelateditems_Block_Adminhtml_Mostsellproduct_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('id');
        $this->setTitle(Mage::helper('Mostsellingrelateditems')->__('Edit'));
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('mostsellproduct');
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('Mostsellingrelateditems')->__('General Information'), 'class' => 'fieldset-wide'));
        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }
        $fieldset->addField(
            'most_selling_product_id',
            'select',
            array(
                'name' => 'most_selling_product_id',
                'label' => Mage::helper('Mostsellingrelateditems')->__('most_selling_product_id'),
                'title' => Mage::helper('Mostsellingrelateditems')->__('most_selling_product_id'),
                'required' => true,
                'options'=> Ccc_Mostsellingrelateditems_Model_Mostsellproduct::getProductArray()
            )
        );
       
        $fieldset->addField(
            'related_product_id',
            'select',
            array(
                'name' => 'related_product_id',
                'label' => Mage::helper('Mostsellingrelateditems')->__('related_product_id'),
                'title' => Mage::helper('Mostsellingrelateditems')->__('related_product_id'),
                'required' => true,
                'options'=> Ccc_Mostsellingrelateditems_Model_Mostsellproduct::getProductArray()
            )
        );
        $fieldset->addField(
            'is_deleted',
            'select',
            array(
                'name' => 'is_deleted',
                'label' => Mage::helper('Mostsellingrelateditems')->__('Is Deleted'),
                'title' => Mage::helper('Mostsellingrelateditems')->__('Is Deleted'),
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('Mostsellingrelateditems')->__('Yes'),
                    '2' => Mage::helper('Mostsellingrelateditems')->__('No'),
                ),
            
            )
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
?>