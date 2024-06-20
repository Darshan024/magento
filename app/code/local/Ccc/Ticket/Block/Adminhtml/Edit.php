<?php
class Ccc_Ticket_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        $this->setTemplate('ticket/edit/edit.phtml');
        $this->_controller = 'adminhtml_ticket';
        $this->_blockGroup = 'edit';
        $this->_headerText = Mage::helper('ticket')->__('Ticket Edit');
        parent::__construct();
        $this->removeButton('add');
    }
    public function getTicket($Id){
        $ticket = Mage::getModel('ticket/ticket')->load($Id);
        return $ticket;
    }
    public function getUserCollection()
    {
        $users = Mage::getModel('admin/user')->getCollection();
        return $users;
    }
    public function getStatusData($statusCode){
        $status = Mage::getModel('ticket/status')->load($statusCode,'status_code');
        return $status;
    }
    public function getStatusArray()
    {
        $status = Mage::getModel('ticket/status')->getCollection();
        return $status;
    }
    public function getCurrentUser(){
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }
    public function getCommentData($id){
        $comments = Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id', $id);
        return $comments->getData();
    }
}
?>