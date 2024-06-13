<?php
class Ccc_Filetransfer_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'config_id';
        $this->_controller = 'adminhtml_configuration';
        $this->_blockGroup = 'filetransfer';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('filetransfer')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('filetransfer')->__('Delete'));
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
        if (Mage::registry('filetransfer_configuration')->getId()) {
            return Mage::helper('filetransfer')->__("Edit", $this->escapeHtml(Mage::registry('filetransfer_configuration')->getTitle()));
        } else {
            return Mage::helper('filetransfer')->__('New');
        }
    }
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            array(
                '_current' => true,
                'back' => 'edit',
                'active_tab' => '{{tab_id}}'
            )
        );
    }
}
?>