<?php
class Ccc_Ticket_Block_Adminhtml_Page_Menu extends Mage_Adminhtml_Block_Page_Menu
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('ticket/page/menu.phtml');
    }
    public function getUserCollection()
    {
        $users = Mage::getModel('admin/user')->getCollection();
        return $users;
    }
    public function getStatusArray()
    {
        $status = Mage::getModel('ticket/status')->getCollection();
        return $status;
    }
    public function getCurrentUser(){
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }
}
?>