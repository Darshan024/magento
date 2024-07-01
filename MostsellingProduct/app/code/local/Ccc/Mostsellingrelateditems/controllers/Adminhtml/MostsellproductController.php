<?php
class Ccc_Mostsellingrelateditems_Adminhtml_MostsellproductController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('edit'))->_title($this->__('Mostsellingrelateditems'));

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('mostsellingrelateditems/mostsellproduct');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('Mostsellingrelateditems')->__('This seller no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('mostsellproduct', $model);

        $this->_initAction()
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('mostsellingrelateditems/mostsellproduct');

            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }
            $model->setData($data);
            try {
                Mage::dispatchEvent('most_sell_product_save_before', array('product' => $model));
                $model->save();
                Mage::dispatchEvent('most_sell_product_save_before', array('product' => $model));

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('Mostsellingrelateditems')->__('The page has been saved.')
                );

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('Mostsellingrelateditems')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
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
                $seller = Mage::getModel('mostsellingrelateditems/mostsellproduct')->load($Id);
                if ($seller->getIsDeleted() != $status) {
                    $seller->setIsDeleted($status)->save();
                    $count++;
                }
            }
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', $count)
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been not deleted.', $count)
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
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('mostsellingrelateditems/mostsellproduct');
                $model->load($id);
                $model->setData('is_deleted', 1)->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('Mostsellingrelateditems')->__('The block has been deleted.'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('Mostsellingrelateditems')->__('Unable to find a block to delete.'));
        $this->_redirect('*/*/');
    }

}
?>