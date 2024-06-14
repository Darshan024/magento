<?php
class Ccc_Salesman_Block_Adminhtml_Compare extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_compare';
        $this->_blockGroup = 'salesman';
        $this->_headerText = Mage::helper('salesman')->__('Salesman Comparison');
        parent::__construct();
        $this->removeButton('add');
    }
    public function getSalesmen()
    {
        // print_r(Mage::getSingleton('admin/session')->getUser()->getRole()->getRoleName();
        $salesmen = Mage::getModel('admin/user')->getCollection();
        $salesmen->getSelect()->join(
            array("role" => $salesmen->getTable('admin/role')),
            'main_table.user_id=role.user_id',
            array('parent_id')
        );
        $salesmen->addFieldToFilter('parent_id', '50');
        return $salesmen;
    }
    public function getMetrics(){
        $metrics = [
            "total_worked_orders" => "Total Worked Orders",
            "total_upsell_orders" => "Total Upsell Orders",
            "total_commission_orders" => "Total Commission Orders",
            "total_upsold" => "Total Upsold",
            "total_commission" => "Total Commission",
            "product_upsold" => "Product Upsold",
            "shipping_upsold" => "Shipping Upsold",
            "tax_upsold" => "Tax Upsold",
            "product_commission" => "Product Commission",
            "shipping_commission" => "Shipping Commission",
            "tax_commission" => "Tax Commission",
        ];
        return $metrics;
    }
}
?>