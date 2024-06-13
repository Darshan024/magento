<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'config_id';
        $this->_controller = 'adminhtml_configuration';
        $this->_blockGroup = 'outlook';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('outlook')->__('Save Configuration'));
        $this->_updateButton('delete', 'label', Mage::helper('outlook')->__('Delete Configuration'));
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
   
    public function getHeaderText()
    {
        if (Mage::registry('outlook_configuration')->getId()) {
            return Mage::helper('outlook')->__("Edit Configuration ", $this->escapeHtml(Mage::registry('outlook_configuration')->getTitle()));
        } else {
            return Mage::helper('outlook')->__('New Configuration');
        }
    }
}
?>