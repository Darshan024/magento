<?php
class Ccc_Ticket_Block_Adminhtml_Comment extends Mage_Adminhtml_Block_Widget_Container
{

    public function __construct()
    {
        $this->setTemplate('ticket/edit/comment.phtml');
        parent::__construct();
    }
    public function getTicket()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $ticket = Mage::getModel('ticket/ticket')->load($id);
        return $ticket;
    }
    public function getCurrentUser()
    {
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }
    public function getCommentData()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $comments = Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id', $id);
        if ($this->getRequest()->getParam('hide')=='false') {
            $comments->addFieldToFilter('is_completed', array('neq' => 'Completed'));
        }
        $commentsData = [];
        foreach ($comments as $comment) {
            if ($comment->getParentId() == 0) {
                $rowspan = $this->calculateRowspan($comment->getId());
                $commentsData[] = [
                    'comment_id' => $comment->getId(),
                    'user_id' => $comment->getUserId(),
                    'comment' => $comment->getComment(),
                    'parent_id' => $comment->getParentId(),
                    'created_at' => $comment->getCreatedAt(),
                    'level' => $comment->getLevel(),
                    'is_question' => $comment->getIsQuestion(),
                    'is_completed' => $comment->getIsCompleted(),
                    'is_locked' => $comment->getIsLocked(),
                    'rowspan' => $rowspan,
                    'replies' => $this->getCommentsHierarchy($comment->getId())
                ];
            }
        }
        return $commentsData;
    }
    public function getCommentsHierarchy($parentId)
    {
        $commentsCollection = Mage::getModel('ticket/comment')->getCollection()
            ->addFieldToFilter('parent_id', $parentId);

        if ($this->getRequest()->getParam('hide')=='false') {
            $commentsCollection->addFieldToFilter('is_completed', array('neq' => 'Completed'));
        }
        $commentsData = [];

        foreach ($commentsCollection as $comment) {
            $rowspan = $this->calculateRowspan($comment->getId());
            $isQuestion = $this->isQuestionReply($comment->getParentId());
            $commentsData[] = [
                'comment_id' => $comment->getId(),
                'user_id' => $comment->getUserId(),
                'comment' => $comment->getComment(),
                'parent_id' => $comment->getParentId(),
                'level' => $comment->getLevel(),
                'is_question' => $isQuestion,
                'created_at' => $comment->getCreatedAt(),
                'is_completed' => $comment->getIsCompleted(),
                'is_locked' => $comment->getIsLocked(),
                'rowspan' => $rowspan,
                'replies' => $this->getCommentsHierarchy($comment->getId())
            ];
        }
        return $commentsData;
    }
    public function calculateRowspan($commentId)
    {
        $commentsCollection = Mage::getModel('ticket/comment')->getCollection()
            ->addFieldToFilter('parent_id', $commentId);
        $rowspan = 1;

        foreach ($commentsCollection as $comment) {
            $rowspan += $this->calculateRowspan($comment->getId());
        }
        return $rowspan;
    }
    public function getLocklevel()
    {
        $ticketId = $this->getRequest()->getParam('ticket_id');
        $comments = Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id', $ticketId)->setOrder('level','DESC');
        $level = $comments->getFirstItem()->getLevel();
        return $level;
    }
    public function isQuestionReply($parentId){
        $commentModel = Mage::getModel('ticket/comment')->load($parentId);
        if ($commentModel->getParentId() == 0) {
            return $commentModel->getIsQuestion();
        } else {
            return $this->isQuestionReply($commentModel->getParentId());
        }
    }
    
}
?>