<?php
class Ccc_Ticket_Adminhtml_TicketController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ticket');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('ticket'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $data = $this->getRequest()->getParam('ticket');
            $model = Mage::getModel('ticket/ticket');
            $model->setData($data);
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ticket')->__('The page has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                $this->_redirect('*/ticket/index');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('ticket')->__('An error occurred while saving the page.')
                );
            }
        }
        $this->_redirect('*/*/');
    }
    public function viewAction()
    {
        $this->_initAction()
            ->renderLayout();

    }
    public function updateAction()
    {
        $data = $this->getRequest()->getParams();
        $column = $data['column'];
        $value = $data['value'];
        $ticketId = $data['id'];
        $status = Mage::getModel('ticket/status')->load($value, 'status_code');
        $ticketModel = Mage::getModel('ticket/ticket')->load($ticketId)->setData($column, $value)->save();
        if ($column == 'status') {
            $response['message'] = 'success';
            $response['colour'] = $status->getColourCode();
            $this->getResponse()->setBody(json_encode($response));
        }
    }
    public function savecommentAction()
    {
        $data = $this->getRequest()->getParams();
        $commentModel = Mage::getModel('ticket/comment');
        if ($ticketId = $this->getRequest()->getParam('ticket_id')) {
            $commentData = [
                'ticket_id' => $ticketId,
                'comment' => $data['comment'],
                'user_id' => $data['user_id'],
                'is_completed'=>1,
                'is_locked'=>1,
                'level'=>0
            ];
            $commentModel->setData($commentData)->save();
        }
        $this->_redirect('*/*/view', array('ticket_id' => $this->getRequest()->getParam('ticket_id')));
    }
    public function savefilterAction()
    {
        $data = $this->getRequest()->getParams();
        $filterName = $data['filter_name'];
        $createAt = $data['created_at'];
        $status = implode(',', $data['status']);
        $assignTo = implode(',', $data['assign_to']);
        $filterData = [
            'status' => $status,
            'assign_to' => $assignTo,
            'lastcomment' => $data['last_comment'],
            'filter_name' => $filterName,
            'create_at' => $createAt
        ];
        Mage::getModel('ticket/filter')->setData($filterData)->save();
        $this->_redirect('*/*/index');
    }
    public function savechildcommentAction(){
        $data=$this->getRequest()->getParams();
        $parentId = $data['parent_id'];
        $parentModel = Mage::getModel('ticket/comment')->load($parentId)->setData('is_completed',2)->save();
        $level = $parentModel->getLevel();
        $data['level'] = $level + 1;
        $data['is_completed'] = 1;
        $childComment=Mage::getModel('ticket/comment')->setData($data)->save();
    }
    public function saveCompleteAction(){
        $data = $this->getRequest()->getParams();
        $commentModel = Mage::getModel('ticket/comment')->load($data['comment_id'])->setData('is_completed',2)->save();
    }
    public function saveLockAction(){
        $level=$this->getRequest()->getParam('level');
        $commentModel = Mage::getModel('ticket/comment');

        $commentCollection = $commentModel->getCollection()->addFieldToFilter('level', $level);
        foreach($commentCollection as $comment){
            $commentModel->load($comment->getId())->addData(['is_locked'=>2,'is_completed'=>2])->save();
        }

        $nextLevel = $level + 1;
        $childComments = $commentModel->getCollection()->addFieldToFilter('level', $nextLevel);
        foreach($childComments as $comment){
            $commentModel->load($comment->getId())->addData(['is_locked'=>1])->save();
        }
    }
    public function savequestionAction(){
        $data = $this->getRequest()->getParams();
        $commentData = [
            'ticket_id' => $data['ticketId'],
            'comment' => $data['comment'],
            'user_id'=>$data['userId'],
            'parent_id'=>0,
            'is_completed'=>1,
            'level'=>$data['level'],
            'is_locked'=>1,
        ];
        Mage::getModel('ticket/comment')->setData($commentData)->save();
    }
}
?>