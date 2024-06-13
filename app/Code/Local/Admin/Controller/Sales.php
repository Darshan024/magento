<?php
class Admin_Controller_Sales extends Core_Controller_Admin_Action
{
    public function indexAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $orderPlace = $layout->createBlock('sales/admin_order_order');
        $layout->getChild('head')->addCss('admin/order.css');
        $child->addChild('orderPlace', $orderPlace);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $defaultUserStatus = Sales_Model_Status::DEFAULT_ORDER_USER_STATUS;
        $status = $this->getRequest()->getParams('status');
        $orderId = $status['order_id'];
        $fromStatus = Mage::getModel('sales/order')->load($orderId)->getStatus();
        Mage::getModel('sales/order')->setData($status)->save();
        Mage::getModel('sales/order_history')->setData(
            [
                'order_id' => $orderId,
                'from_status' => $fromStatus,
                'to_status' => $status['status'],
                'action_by' => $defaultUserStatus
            ]
        )->save();
        $this->setRedirect('admin/sales');
    }

    public function acceptAction()
    {
        $orderId = $this->getRequest()->getParams('id');
        $data = [
            'order_id' => $orderId,
            'status' => 'canceled'
        ];
        Mage::getModel('sales/order_history')->updateHistory($data, 1);
        Mage::getModel('sales/order')->setData($data)->save();
        $this->setRedirect('admin/sales/index');
    }
    public function rejectAction()
    {
        $orderId = $this->getRequest()->getParams('id');
        $data = [
            'order_id' => $orderId,
            'status' => 'declined'
        ];
        Mage::getModel('sales/order_history')->updateHistory($data, 1);
        Mage::getModel('sales/order')->setData($data)->save();
        $this->setRedirect('admin/sales/index');
    }
    public function viewAction(){
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        $orderView = $layout->createBlock('sales/admin_order_view');
        $layout->getChild('head')->addCss('admin/view.css');
        $child->addChild('orderView', $orderView);
        $layout->toHtml();
        // $orderId = $this->getRequest()->getParams('id');

    }

    // public function acceptAction()
    // {
    //     echo '<pre>';
    //     $id = $this->getRequest()->getParams('id');
    //     $fromStatus = Mage::getModel('sales/order')->load($id);
    //     // print_r($fromStatus);
    //     // die;
    //     Mage::getModel('sales/order_history')->setData(
    //         [
    //             // 'history_id' => $fromStatus->getHistoryId(),
    //             'order_id' => $fromStatus->getOrderId(),
    //             'from_status' => $fromStatus->getToStatus(),
    //             'to_status' => 'accept',
    //             'action_by' => 1
    //         ]
    //     )->save();
    //     // $this->setRedirect('admin/cancel');
    // }
    // public function rejectAction()
    // {
    //     $id = $this->getRequest()->getParams('id');
    //     $fromStatus = Mage::getModel('sales/order_history')->load($id);
    //     Mage::getModel('sales/order_history')->setData(
    //         [
    //             // 'history_id' => $fromStatus->getHistoryId(),
    //             'order_id' => $fromStatus->getOrderId(),
    //             'from_status' => $fromStatus->getToStatus(),
    //             'to_status' => 'rejected',
    //             'action_by' => 1
    //         ]
    //     )->save();
    //     // $this->setRedirect('admin/cancel');
    // }
}