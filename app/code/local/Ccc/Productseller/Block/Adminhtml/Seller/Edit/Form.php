<?php
class Ccc_Productseller_Block_Adminhtml_Seller_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('entity_id');
        $this->setTitle(Mage::helper('productseller')->__('Edit'));
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('productseller_seller');
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('productseller')->__('General Information'), 'class' => 'fieldset-wide'));
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
            'seller_name',
            'text',
            array(
                'name' => 'seller_name',
                'label' => Mage::helper('productseller')->__('Seller Name'),
                'title' => Mage::helper('productseller')->__('Seller Name'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'company_name',
            'text',
            array(
                'name' => 'company_name',
                'label' => Mage::helper('productseller')->__('Company Name'),
                'title' => Mage::helper('productseller')->__('Company Name'),
                'required' => true,
            
            )
        );
        $fieldset->addField(
            'address',
            'text',
            array(
                'name' => 'address',
                'label' => Mage::helper('productseller')->__('Address'),
                'title' => Mage::helper('productseller')->__('Address'),
                'required' => true,
            
            )
        );
        $fieldset->addField(
            'city',
            'text',
            array(
                'name' => 'city',
                'label' => Mage::helper('productseller')->__('City'),
                'title' => Mage::helper('productseller')->__('City'),
                'required' => true,
            
            )
        );
        $fieldset->addField(
            'state',
            'text',
            array(
                'name' => 'state',
                'label' => Mage::helper('productseller')->__('state'),
                'title' => Mage::helper('productseller')->__('state'),
                'required' => true,
            
            )
        );
        $fieldset->addField(
            'country',
            'text',
            array(
                'name' => 'country',
                'label' => Mage::helper('productseller')->__('Country'),
                'title' => Mage::helper('productseller')->__('Country'),
                'required' => true,
            
            )
        );
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => Mage::helper('productseller')->__('Is Active'),
                'title' => Mage::helper('productseller')->__('Is Active'),
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('productseller')->__('Yes'),
                    '2' => Mage::helper('productseller')->__('No'),
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