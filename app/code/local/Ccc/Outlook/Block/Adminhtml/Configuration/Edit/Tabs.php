<?php

class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('outlook')->__('Configuration Information'));
    }
    protected function _beforeToHtml()
    {
        $this->addTab(
            'general',
            array(
                'label' => Mage::helper('outlook')->__('General'),
                'content' => $this->getLayout()->createBlock('outlook/adminhtml_configuration_edit_tab_content')->initForm()->toHtml(),
                'active' => Mage::registry('outlook_configuration')->getId() ? false : true
            )
        );
        $this->addTab(
            'dispatch_event',
            array(
                'label' => 'Event',
                'title' => 'Dispath Event',
                'content' => $this->getLayout()->createBlock('outlook/adminhtml_configuration_edit_tab_event')->toHtml(),
                'active' => Mage::registry('outlook_configuration') ? true : false,
            )
        );
        return parent::_beforeToHtml();
    }

}
