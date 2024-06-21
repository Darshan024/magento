<?php
class Ccc_Ticket_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        $this->setTemplate('ticket/container.phtml');
        $this->_headerText = Mage::helper('ticket')->__('Ticket');
        parent::__construct();
    }
    public function getTicketCollection()
    {
        $page = (int) $this->getRequest()->getParam('p', 1);
        $collection = Mage::getModel('ticket/ticket')->getCollection();
        $collection->setPageSize(4);
        $collection->setCurPage($page);
        $filterId = $this->getRequest()->getParam('filter_id');
        if ($filterId) {
            $filterModel = Mage::getModel('ticket/filter')->load($filterId);
            $status = explode(',', $filterModel->getStatus());
            $assignTo = explode(',', $filterModel->getAssignTo());
            $currentDate = new DateTime();
            $CommentuserId = $filterModel->getLastcomment();
            $currentDate = $currentDate->modify('-' . $filterModel->getCreateAt() . 'days')->format('Y-m-d H:i:s');
            $collection->addFieldToFilter('status', $status)->addFieldToFilter('assign_to', $assignTo)->addFieldToFilter('created_at', array('gteq' => $currentDate));
            $ticketIds = $this->getLastCommentTikets($CommentuserId);
            if($ticketIds){
                $collection->addFieldToFilter('ticket_id', ['in' => $ticketIds]);
            }
        }
        return $collection;
    }
    public function getStatusData($statusCode)
    {
        $status = Mage::getModel('ticket/status')->load($statusCode, 'status_code');
        return $status;
    }
    public function getUser($adminId)
    {
        $adminUser = Mage::getModel('admin/user')->load($adminId);
        return $adminUser;
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
    public function getTotalPage()
    {
        $collection = $this->getTicketCollection();
        $totalPage = ceil($collection->getSize() / $collection->getPageSize());
        return $totalPage;
    }
    public function getFilterCollection()
    {
        $collection = Mage::getModel('ticket/filter')->getCollection();
        return $collection;
    }
    public function getCurrentPage()
    {
        return $this->getRequest()->getParam('p');
    }
    public function getLastCommentTikets($userId)
    {
        $commentCollection = Mage::getModel('ticket/comment')->getCollection();
        $subquery = new Zend_Db_Expr(
            '(SELECT MAX(comment_id) FROM ticket_comment GROUP BY ticket_id)'
        );
        $commentCollection->getSelect()
            ->where('main_table.comment_id IN ' . $subquery)
            ->order('main_table.created_at DESC');
        $commentCollection->addFieldToFilter('user_id',$userId);
        $ticketIds = [];
        foreach ($commentCollection as $comment) {
            $ticketIds[] = $comment->getTicketId();
        }
        return $ticketIds;
    }
}
?>