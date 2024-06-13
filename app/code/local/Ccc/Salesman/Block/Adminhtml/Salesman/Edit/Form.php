<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Form extends Mage_ADminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('entity_id');
        $this->setTitle(Mage::helper('salesman')->__('Salesman'));
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        // if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        // }
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('salesman_salesman');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('salesman')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                array(
                    'name' => 'entity_id',
                )
            );
        }
        $options = array();
        $collection = Mage::getResourceModel('admin/user_collection')->getData();
        foreach ($collection as $item) {
            $options[$item['user_id']] = $item['username'];
        }
        $fieldset->addField(
            'user_id',
            'select',
            array(
                'name' => 'user_id',
                'label' => Mage::helper('salesman')->__('User Id'),
                'title' => Mage::helper('salesman')->__('User Id'),
                'required' => true,
                'options' => $options,
            )
        );

        $fieldset->addField(
            'metric',
            'select',
            array(
                'label' => Mage::helper('salesman')->__('Metric'),
                'title' => Mage::helper('salesman')->__('Metric'),
                'name' => 'metric',
                'required' => true,
                'options' => 
                    Ccc_Salesman_Model_Salesman::getOptionArray(),
            )
        );

        $fieldset->addField(
            'percentage',
            'text',
            array(
                'name' => 'percentage',
                'label' => Mage::helper('salesman')->__('Percentage'),
                'title' => Mage::helper('salesman')->__('Percentage'),
                'required' => true,
            )
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
?>