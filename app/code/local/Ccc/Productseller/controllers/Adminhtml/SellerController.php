<?php
class Ccc_Productseller_Adminhtml_SellerController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customer');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('customer'));
        $this->_title($this->__('productseller'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('edit'))->_title($this->__('seller'));

        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('productseller/seller');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productseller')->__('This seller no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('productseller_seller', $model);

        $this->_initAction()
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('productseller/seller');

            if ($id = $this->getRequest()->getParam('entity_id')) {
                $model->load($id);
            }
            $model->setData($data);
            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('productseller')->__('The page has been saved.')
                );

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('entity_id' => $model->getId(), '_current' => true));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('productseller')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function massStatusAction()
    {
        $Ids = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('status');
        if (!is_array($Ids)) {
            $Ids = array($Ids);
        }
        $count = 0;
        try {
            foreach ($Ids as $Id) {
                $seller = Mage::getModel('productseller/seller')->load($Id);
                if ($seller->getIsActive() != $status) {
                    $seller->setIsActive($status)->save();
                    $count++;
                }
            }
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been active.', $count)
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deactivate.', $count)
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'customer/seller/index';
                break;
            case 'new':
                $aclResource = 'customer/seller/new';
                break;
            case 'edit':
                $aclResource = 'customer/seller/edit';
                break;
            case 'delete':
                $aclResource = 'customer/seller/delete';
                break;
            default:
                $aclResource = 'customer/seller';
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('entity_id')) {
            $title = "";
            try {
                $model = Mage::getModel('productseller/seller');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productseller')->__('The block has been deleted.'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productseller')->__('Unable to find a block to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
}
?>