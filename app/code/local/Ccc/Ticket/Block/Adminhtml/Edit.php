<?php
class Ccc_Ticket_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Container
{

    public function __construct()
    {
        $this->setTemplate('ticket/edit/edit.phtml');
        parent::__construct();
    }
    public function getTicket()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $ticket = Mage::getModel('ticket/ticket')->load($id);
        return $ticket;
    }
    public function getUserCollection()
    {
        $users = Mage::getModel('admin/user')->getCollection();
        return $users;
    }
    public function getStatusData($statusCode)
    {
        $status = Mage::getModel('ticket/status')->load($statusCode, 'status_code');
        return $status;
    }
    public function getStatusArray()
    {
        $status = Mage::getModel('ticket/status')->getCollection();
        return $status;
    }
    public function getCurrentUser()
    {
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }
    public function getLocklevel()
    {
        $ticketId = $this->getRequest()->getParam('ticket_id');
        $comments = Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id', $ticketId)->setOrder('level','DESC');
        $level = $comments->getFirstItem()->getLevel();
        return $level;
    }
}
?>