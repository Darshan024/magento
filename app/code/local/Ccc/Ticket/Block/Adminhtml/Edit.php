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
    public function getTicket(){
        $id = $this->getRequest()->getParam('ticket_id');
        $ticket = Mage::getModel('ticket/ticket')->load($id);
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
    public function getCommentData(){
        $id = $this->getRequest()->getParam('ticket_id');
        $comments = Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id', $id);
        $commentsData = [];
        foreach($comments as $comment){
            if ($comment->getParentId() == 0) {
                $commentsData[] = [
                    'comment_id' => $comment->getId(),
                    'user_id' => $comment->getUserId(),
                    'comment' => $comment->getComment(),
                    'parent_id' => $comment->getParentId(),
                    'created_at' => $comment->getCreatedAt(),
                    'is_locked'=>$comment->getIsLocked(),
                    'replies' => $this->getCommentsHierarchy($comment->getId())
                ];
            }
        }
        return $commentsData;
    }
    public function getCommentsHierarchy($parentId)
    {
        $commentsCollection = Mage::getModel('ticket/comment')->getCollection()
            ->addFieldToFilter('parent_id',$parentId);
        $commentsData = [];

        foreach ($commentsCollection as $comment) {
            $commentsData[] = [
                'comment_id' => $comment->getId(),
                'user_id' => $comment->getUserId(),
                'comment' => $comment->getComment(),
                'parent_id' => $comment->getParentId(),
                'created_at' => $comment->getCreatedAt(),
                'is_locked'=>$comment->getIsLocked(),
                'replies' => $this->getCommentsHierarchy($comment->getId())
            ];
        }
        return $commentsData;
    }
}
?>