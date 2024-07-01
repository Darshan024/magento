<?php
class Ccc_Mostsellingrelateditems_Block_Adminhtml_Mostsellproduct_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_mostsellproduct';
        $this->_blockGroup = 'Mostsellingrelateditems';
        $this->_objectId = 'id';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('Mostsellingrelateditems')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('Mostsellingrelateditems')->__('Delete'));
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
        if (Mage::registry('mostsellproduct')->getId()) {
            return Mage::helper('Mostsellingrelateditems')->__("Edit Product");
        } else {
            return Mage::helper('Mostsellingrelateditems')->__('New Product');
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