<?php
class Ccc_Productseller_Block_Adminhtml_Seller_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_seller';
        $this->_blockGroup = 'productseller';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('productseller')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('productseller')->__('Delete'));
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
        if (Mage::registry('productseller_seller')->getId()) {
            return Mage::helper('productseller')->__("Edit Seller");
        } else {
            return Mage::helper('productseller')->__('New Seller');
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