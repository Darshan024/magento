<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_salesman';
        $this->_blockGroup = 'salesman';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('salesman')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('salesman')->__('Delete'));
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('banner_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'banner_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'banner_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    public function getHeaderText()
    {
        if (Mage::registry('salesman_salesman')->getId()) {
            return Mage::helper('salesman')->__("Edit", $this->escapeHtml(Mage::registry('salesman_salesman')->getTitle()));
        } else {
            return Mage::helper('salesman')->__('New');
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