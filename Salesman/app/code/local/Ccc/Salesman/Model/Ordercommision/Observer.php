<?php
class Ccc_Salesman_Model_Ordercommision_Observer
{
    public function checkSalesman(Varien_Event_Observer $observer)
    {
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $salesman = Mage::getModel('salesman/salesman')
            ->getCollection()
            ->addFieldToFilter('user_id', $userId)
            ->getData();
        if (!$salesman) {
            $message = 'You cannot place orders because you are not assigned as a salesman.';
            Mage::getSingleton('adminhtml/session')->addError($message);
            $url = Mage::helper('adminhtml')->getUrl('adminhtml/sales_order_create/index');
            Mage::app()->getResponse()->setRedirect($url)->sendResponse();
            exit;
        }
    }
    public function cancelOrderCommission(Varien_Event_Observer $observer)
    {
        $orderData = $observer->getOrder();
        $orderCollection = Mage::getModel('salesman/ordercommision')
            ->getCollection()
            ->addFieldToFilter('order_id', $orderData->getId());
        foreach ($orderCollection->getData() as $order) {
            if (isset($order['entity_id'])) {
                unset($order['entity_id']);
            }
            $order['commission'] = 0 - ($order['commission']);
            $order['upsold'] = 0 - ($order['upsold']);
            $commisionModel = Mage::getModel('salesman/ordercommision');
            $commisionModel->setData($order)->save();
        }
    }
    public function addOrdercommission(Varien_Event_Observer $observer)
    {
        // $commissionData = [];
        $order = $observer->getOrder();
        $orderId = $order->getId();
        $taxAmount = $order->getTaxAmount();
        $shippingAmount = $order->getShippingAmount();
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();

        $items = $order->getAllVisibleItems();
        $salesmanModel = Mage::getModel('salesman/salesman')
            ->getCollection()
            ->addFieldToFilter('user_id', $userId);
        $commissionModel = Mage::getModel('salesman/ordercommision');
        if (!$salesmanModel->getSize()) {
            $commissionData = [
                'user_id' => $userId,
                'order_id' => $orderId,
                'percentage' => 0,
                'commission' => 0,
            ];
            $productData = $shippingData = $taxData = $commissionData;
            foreach ($items as $item) {
                $productData['product_id'] = $item->getProductId();
                $productData['new_price'] = $item->getBasePrice();
                $productData['old_price'] = $item->getOriginalPrice();
                $productData['upsold'] = $item->getBasePrice() - $item->getOriginalPrice();
                $productData['description'] = Mage::getModel('salesman/product')->getNameForDescription($item->getProductId());
                $productData['metric'] = Ccc_Salesman_Model_Salesman::METRIC_PRODUCT;
                $commissionModel->setData($productData)->save();
            }

            $shippingData['metric'] = Ccc_Salesman_Model_Salesman::METRIC_SHIPPING;
            $shippingData['upsold'] = $shippingAmount;
            $shippingData['description'] = "Added shipping price " . $shippingData['upsold'];
            $commissionModel->setData($shippingData)->save();

            $taxData['metric'] = Ccc_Salesman_Model_Salesman::METRIC_TAX;
            $taxData['upsold'] = $taxAmount;
            $taxData['description'] = "Added tax price " . $taxData['upsold'];
            $commissionModel->setData($taxData)->save();
        } else {
            foreach ($salesmanModel as $salesman) {
                if ($salesman->getMetric() == Ccc_Salesman_Model_Salesman::METRIC_PRODUCT) {
                    foreach ($items as $item) {
                        $productData['user_id'] = $userId;
                        $productData['order_id'] = $item->getOrderId();
                        $productData['product_id'] = $item->getProductId();
                        $productData['old_price'] = $item->getQtyOrdered() * $item->getOriginalPrice();
                        $productData['new_price'] = $item->getQtyOrdered() * $item->getBasePrice();
                        $productData['upsold'] = $item->getBasePrice() - $item->getOriginalPrice();
                        $productData['metric'] = $salesman->getMetric();
                        if (Mage::getModel('salesman/product')->getAttributeIsLowSellProduct($item->getProductId()) == "Yes") {
                            $productData['percentage'] = Mage::getStoreConfig("salesman/metric/low_sell_product_percentage") + $salesman->getPercentage();
                        } else {
                            $productData['percentage'] = $salesman->getPercentage();
                        }
                        $productData['description'] = Mage::getModel('salesman/product')->getNameForDescription($item->getProductId());
                        $productData['commission'] = (($productData['percentage'] / 100) * $productData['upsold']);
                        $commissionModel->setData($productData)->save();
                    }
                } elseif ($salesman->getMetric() == Ccc_Salesman_Model_Salesman::METRIC_SHIPPING) {
                    $shippingData['user_id'] = $userId;
                    $shippingData['order_id'] = $orderId;
                    $shippingData['upsold'] = $shippingAmount;
                    $shippingData['metric'] = $salesman->getMetric();
                    $shippingData['percentage'] = $salesman->getPercentage();
                    $shippingData['commission'] = (($salesman->getPercentage() / 100) * $shippingData['upsold']);
                    $shippingData['description'] = "Added Shipping Price " . $shippingData['upsold'];
                    $commissionModel->setData($shippingData)->save();

                } elseif ($salesman->getMetric() == Ccc_Salesman_Model_Salesman::METRIC_TAX) {
                    $taxData['user_id'] = $userId;
                    $taxData['order_id'] = $orderId;
                    $taxData['upsold'] = $taxAmount;
                    $taxData['metric'] = $salesman->getMetric();
                    $taxData['percentage'] = $salesman->getPercentage();
                    $taxData['commission'] = (($salesman->getPercentage() / 100) * $taxData['upsold']);
                    $taxData['description'] = "Added Tax Price " . $taxData['upsold'];
                    $commissionModel->setData($taxData)->save();
                }
            }
        }
    }
    public function newUser(Varien_Event_Observer $observer)
    {
        $user = $observer->getObject();
        $userId = $user->getUserId();
        $salesman = Mage::getModel('salesman/salesman')->getCollection()->addFieldToFilter('user_id', $userId)->getData();
        $userRoleId = isset($user->getData()['roles'][0]) ? $user->getData()['roles'][0] : 0;
        if ($userRoleId == 50 && empty($salesman)) {
            $salesmanCollection = Mage::getModel('salesman/salesman');
            foreach (Ccc_Salesman_Model_Salesman::getOptionArray() as $key => $value) {
                $data = [
                    'user_id' => $userId,
                    'metric' => $key,
                    'percentage' => Mage::getStoreConfig("salesman/metric/{$key}")
                ];
                $salesmanCollection->setData($data)->save();
            }
        }
    }
    public function checkEvent(Varien_Event_Observer $observer)
    {
        $modelData = $observer->getSalesman();
        $id = $modelData->getUserId();
        $metric = $modelData->getMetric();
        $existingSalesman = Mage::getModel('salesman/salesman')
            ->getCollection()
            ->addFieldToFilter('user_id', $id)
            ->addFieldToFilter('metric', $metric)
            ->getFirstItem();
        if ($existingSalesman->getId()) {
            if ($existingSalesman->getMetric() == $metric) {
                $message = "$metric metric is already set for the user with ID $id";
                Mage::getSingleton('adminhtml/session')->addError($message);
                $url = Mage::helper('adminhtml')->getUrl('adminhtml/salesman/edit');
                Mage::app()->getResponse()->setRedirect($url)->sendResponse();
                exit;
            } else {
                return;
            }
        }
    }

}


?>