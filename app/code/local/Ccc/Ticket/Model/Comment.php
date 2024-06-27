<?php
class Ccc_Ticket_Model_Comment extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ticket/comment');
    }
    public function checkParentComplete($commentId){
        $parentId = $this->load($commentId)->getParentId();
        $childComments = $this->getCollection()->addFieldToFilter('parent_id', $parentId)->addFieldToFilter('is_completed','NotCompleted');
        if(empty($childComments->getData())){
            $this->load($parentId)->setData('is_completed', 'Completed')->save();
            if($parentId!=0){
                $this->checkParentComplete($parentId);
            }
        }
    }
    public function haveReplies($commentId){
        $commentCollection = $this->getCollection()->addFieldToFilter('parent_id',$commentId);
        if(!empty($commentCollection->getData())){
            return true;
        }
        return false;
    } 
}
?>