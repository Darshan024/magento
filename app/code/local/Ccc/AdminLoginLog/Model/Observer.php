<?php
class Ccc_AdminLoginLog_Model_Observer
{
    public function logAdminLogin(Varien_Event_Observer $observer)
    {
        $user = $observer->getUser();
        $log = Mage::getModel('adminloginlog/log');
        $log->setAdminUserId($user->getId())
            ->setLoginAt(now())
            ->save();
    }
    public function logAllEvents($observer)
    {
        $eventName = $observer->getEvent()->getName();
        $controller = Mage::app()->getRequest()->getControllerName();
        $action = Mage::app()->getRequest()->getActionName();
        $module = Mage::app()->getRequest()->getModuleName();

        $logMessage = sprintf(
            "Event: %s, Module: %s, Controller: %s, Action: %s",
            $eventName,
            $module,
            $controller,
            $action
        );

        Mage::log($logMessage, null, 'events.log', true);
    }
    public function updateInventory($observer)
    {
        $order = $observer->getOrder();
        $orderItems = $order->getAllItems();
        foreach ($orderItems as $item) {
            $productId = $item->getProductId();
            $qtyOrdered = $item->getQtyOrdered();
            $product = Mage::getModel('catalog/product')->load($productId);
            if ($product->getId()) {
                $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
                $oldQty = $stockItem->getQty();
                $newQty = $oldQty - $qtyOrdered;
                $stockItem->setData('qty', $newQty);
                $stockItem->save();
            }
        }
    }

    public function sendAdminNotification($observer)
    {
        $customer = $observer->getCustomer();
        $storeId = Mage::app()->getStore()->getId();
        $storeName = Mage::app()->getStore()->getName();
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        $adminEmail = Mage::getStoreConfig('trans_email/ident_support/email');
        $adminName = Mage::getStoreConfig('trans_email/ident_support/name');
        $subject = 'New Customer Registration Notification';
        $message = "A new customer has registered on your website.\n\n";
        $message .= "Customer Details:\n";
        $message .= "Name: " . $customer->getName() . "\n";
        $message .= "Email: " . $customer->getEmail() . "\n";
        $message .= "Registered on: " . now() . "\n";
        $mail = Mage::getModel('core/email')
            ->setToEmail($adminEmail)
            ->setToName($adminName)
            ->setSubject($subject)
            ->setBody($message)
            ->setFromEmail($senderEmail)
            ->setFromName($senderName)
            ->setType('text');
        try {
            $mail->send();
            Mage::log('Admin notification email sent successfully.', null, 'admin_notification.log');
        } catch (Exception $e) {
            Mage::log('Error sending admin notification email: ' . $e->getMessage(), null, 'admin_notification.log');
        }
    }
    public function attributeAdd(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $percentage = $product->getActiveTag();
        $productId = $product->getId();
        if(isset($percentage)) {
            $specialPrice = $product->getPrice() - ($product->getPrice() * $percentage / 100);
            $product->setData('special_price_new',$specialPrice); 
        }
    }
    

}


