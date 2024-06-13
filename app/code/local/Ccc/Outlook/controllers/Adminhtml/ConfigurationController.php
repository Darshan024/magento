<?php
use Mage\Customer\Test\Block\Form\Register;
class Ccc_Outlook_Adminhtml_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('configuration');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Configuration'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Configuration'))->_title($this->__('Edit Configuration'));
        $id = $this->getRequest()->getParam('config_id');
        $model = Mage::getModel('outlook/configuration');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outlook')->__('no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Configuration'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('outlook_configuration', $model);
        $eventModel = Mage::getModel('outlook/event');
        $eventCollection = $eventModel->getCollection()
            ->addFieldToFilter('config_id', $model->getId());
            // ->setOrder('group_id', 'ASC');
    
        $eventsData = [];
        foreach ($eventCollection as $event) {
            $eventsData[$event->getGroupId()]['rows'][] = $event->getData();
        }
        // print_r($eventsData);
        // die;
        Mage::register('outlook_event', $eventsData);
        $this->_initAction()
            ->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('outlook/configuration');
            
            if ($id = $this->getRequest()->getParam('config_id')) {
                $model->load($id);
            }

            $model->setData($data['config']);
            try {
                $model->save();
                $eventModel = Mage::getModel('outlook/event');
                $eventModel->saveData($data['event'],$model);
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('outlook')->__('The page has been saved.')
                );

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('config_id' => $model->getId(), '_current' => true));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('outlook')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('config_id' => $this->getRequest()->getParam('config_id')));
            return;
        }
        $this->_redirect('*/*/');
    }


}
?>
