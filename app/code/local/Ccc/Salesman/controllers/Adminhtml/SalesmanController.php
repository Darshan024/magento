<?php
class Ccc_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('salesman');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Salesman'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Salesman'))->_title($this->__('Salesman'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('salesman/salesman');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('This salesman no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Salesman'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('salesman_salesman', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('salesman')->__('Edit Salesman') : Mage::helper('salesman')->__('New Salesman'), $id ? Mage::helper('salesman')->__('Edit') : Mage::helper('salesman')->__('New'))
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('salesman/salesman');

            if ($id = $this->getRequest()->getParam('entity_id')) {
                $model->load($id);
            }

            $model->setData($data);

            // try to save it
            try {
                Mage::dispatchEvent('salesman_save_before', array('salesman' => $model));
                $model->save();
                Mage::dispatchEvent('salesman_save_after', array('salesman' => $model));

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('salesman')->__('The page has been saved.')
                );
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('entity_id' => $model->getId(), '_current' => true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('salesman')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('entity_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('salesman/salesman');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('The Salesman has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('entity_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Unable to find a salesman to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    public function compareaction()
    {
        $this->_title($this->__('Salesman'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function salesmanordersAction()
    {
        $block = $this->getLayout()->createBlock('salesman/adminhtml_compare_grid');
        $requestData = $this->getRequest()->getParams();
        $data = $block->getOrderData($requestData);
        $this->getResponse()->setBody($data);
    }
    public function gridAction()
    {
        $block = $this->getLayout()->createBlock('salesman/adminhtml_compare_grid');
        $requestData = $this->getRequest()->getParams();
        $data = $block->mainFunction($requestData);
        $this->getResponse()->setBody($data);
    }
    public function metricAction()
    {
        $block = $this->getLayout()->createBlock('salesman/adminhtml_compare_grid');
        $requestData = $this->getRequest()->getParams();
        $data = $block->getPopupData($requestData);
        $this->getResponse()->setBody($data);
    }
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'salesman/salesman_percentage/index';
                break;
            case 'new':
                $aclResource = 'salesman/salesman_percentage/new';
                break;
            case 'edit':
                $aclResource = 'salesman/salesman_percentage/edit';
                break;
            case 'delete':
                $aclResource = 'salesman/salesman_percentage/delete';
                break;
            default:
                $aclResource = 'salesman/salesman_percentage';
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
    public function inlineEditAction()
    {
        $response = array();
        $id = $this->getRequest()->getParam('id');
        $column = $this->getRequest()->getParam('column');
        $value = $this->getRequest()->getParam('value');
        try {
            $model = Mage::getModel('salesman/salesman')->load($id);
            if ($model->getId()) {
                $model->setData($column, $value);
                $model->save();
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['message'] = 'Invalid ID';
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
    public function allAction(){
        $this->_initAction();
        $this->renderLayout();
    }

}
?>