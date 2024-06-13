<?php
class Sales_Controller_Quote extends Core_Controller_Front_Action
{
    public function addAction()
    {
        $request = $this->getRequest()->getParams('cart');
        $quote = Mage::getSingleton('sales/quote')
            ->addProduct($request);
        $this->setRedirect('cart');
    }
    public function deleteAction()
    {
        $itemId = $this->getRequest()->getParams('id');
        $request = ['item_id' => $itemId];
        $quote = Mage::getSingleton('sales/quote')
            ->removeProduct($request);
        $this->setRedirect('cart');
    }
    public function updateAction()
    {
        $request = $this->getRequest()->getParams('cart');
        $quote = Mage::getSingleton('sales/quote')
            ->updateProduct($request);
        $this->setRedirect('cart');
    }
    public function saveAction()
    {
        $addressRequest = $this->getRequest()->getParams('address');
        $addressData = Mage::getSingleton('sales/quote')->addAddress($addressRequest);

        $paymentRequest = $this->getRequest()->getParams('sales_quote_payment_method');
        $paymentData = Mage::getSingleton('sales/quote')->addPayment($paymentRequest);

        $shippingRequest = $this->getRequest()->getParams('sales_quote_shipping_method');
        $shippingData = Mage::getSingleton('sales/quote')->addShipping($shippingRequest);

        Mage::getSingleton('sales/quote')->convert();
        Mage::getSingleton('core/session')->remove('quote_id');
        $this->setRedirect('customer/order');
    }
}
?>