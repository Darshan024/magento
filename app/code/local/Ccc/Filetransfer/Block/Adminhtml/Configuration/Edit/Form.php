<?php
class Ccc_Filetransfer_Block_Adminhtml_Configuration_Edit_Form extends Mage_ADminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('config_id');
        $this->setTitle(Mage::helper('filetransfer')->__('Configuration'));
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
     
    }
    protected function _prepareForm()
    {
        $model = Mage::registry('filetransfer_configuration');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('filetransfer')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField(
                'config_id',
                'hidden',
                array(
                    'name' => 'config_id',
                )
            );
        }
        $fieldset->addField(
            'username',
            'text',
            array(
                'name' => 'username',
                'label' => Mage::helper('filetransfer')->__('Username'),
                'title' => Mage::helper('filetransfer')->__('Username'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'password',
            'text',
            array(
                'name' => 'password',
                'label' => Mage::helper('filetransfer')->__('Password'),
                'title' => Mage::helper('filetransfer')->__('Password'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'port',
            'text',
            array(
                'name' => 'port',
                'label' => Mage::helper('filetransfer')->__('Port'),
                'title' => Mage::helper('filetransfer')->__('Port'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'host',
            'text',
            array(
                'name' => 'host',
                'label' => Mage::helper('filetransfer')->__('host'),
                'title' => Mage::helper('filetransfer')->__('host'),
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