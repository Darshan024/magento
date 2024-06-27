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
                'is_completed' => 'NotCompleted',
                'is_locked' => 'Unlocked',
                'level' => 0
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
    public function saveChildCommentAction()
    {
        $data = $this->getRequest()->getParams();
        $parentId = $data['parent_id'];
        $parentModel = Mage::getModel('ticket/comment')->load($parentId);
        $level = $parentModel->getLevel();
        $data['level'] = $level + 1;
        $data['is_completed'] = 'NotCompleted';
        $childComment = Mage::getModel('ticket/comment')->setData($data)->save();
        $this->getResponse()->setBody($this->getLayout()->createBlock('ticket/adminhtml_comment')->toHtml());
    }
    public function saveCompleteAction()
    {
        $data = $this->getRequest()->getParams();
        $commentModel = Mage::getModel('ticket/comment');
        $comment = $commentModel->load($data['comment_id'])->setData('is_completed', 'Completed')->save();
        $commentModel->checkParentComplete($comment->getId());
        $this->getResponse()->setBody($this->getLayout()->createBlock('ticket/adminhtml_comment')->toHtml());
    }
    public function saveLockAction()
    {
        $level = $this->getRequest()->getParam('level');
        $commentModel = Mage::getModel('ticket/comment');

        $commentCollection = $commentModel->getCollection()->addFieldToFilter('level', $level - 1);
        foreach ($commentCollection as $comment) {
            if ($commentModel->haveReplies($comment->getId())) {
                $commentModel->load($comment->getId())->addData(['is_locked' => 'Locked'])->save();
            } else {
                $commentModel->load($comment->getId())->addData(['is_locked' => 'Locked', 'is_completed' => 'Completed'])->save();
            }
            $commentModel->checkParentComplete($comment->getId());
        }
        $childComments = $commentModel->getCollection()->addFieldToFilter('level', $level);
        foreach ($childComments as $comment) {
            if ($commentModel->haveReplies($comment->getId())) {
                $commentModel->load($comment->getId())->addData(['is_locked' => 'Locked', 'is_completed' => 'Completed'])->save();
            } else {
                $commentModel->load($comment->getId())->addData(['is_locked' => 'Unlocked'])->save();
            }
            $commentModel->checkParentComplete($comment->getId());
        }
        $this->getResponse()->setBody($this->getLayout()->createBlock('ticket/adminhtml_comment')->toHtml());
    }
    public function saveQuestionAction()
    {
        $data = $this->getRequest()->getParams();
        $commentData = [
            'ticket_id' => $data['ticketId'],
            'comment' => $data['comment'],
            'user_id' => $data['userId'],
            'parent_id' => 0,
            'is_completed' => 'NotCompleted',
            'level' => $data['level'],
            'is_locked' => 'Unlocked',
            'is_question' => 1,
        ];
        Mage::getModel('ticket/comment')->setData($commentData)->save();
    }
    public function hideAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock('ticket/adminhtml_comment')->toHtml());
    }
}
?>