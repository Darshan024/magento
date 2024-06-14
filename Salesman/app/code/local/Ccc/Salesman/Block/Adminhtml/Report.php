<?php
class Ccc_Salesman_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_commissionCollection;
    public function __construct()
    {
        $this->_controller = 'adminhtml_report';
        $this->_blockGroup = 'salesman';
        $this->_headerText = Mage::helper('salesman')->__('Report');
        parent::__construct();
        $this->removeButton('add');
    }
    public function getUserCollection()
    {
        $salesmen = Mage::getModel('admin/user')->getCollection();
        $salesmen->getSelect()->join(
            array("role" => $salesmen->getTable('admin/role')),
            'main_table.user_id=role.user_id',
            array('parent_id')
        );
        $salesmen->addFieldToFilter('parent_id', 50);
        return $salesmen;
    }
}
?>