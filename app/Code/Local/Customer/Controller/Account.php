<?php
class Customer_Controller_Account extends Core_Controller_Front_Action
{
    protected $_allowedActions = ['login', 'register', 'forgotPassword'];
    public function init()
    {
        if (
            !in_array($this->getRequest()->getActionName(), $this->_allowedActions) &&
            !Mage::getSingleton('core/session')->get("logged_in_customer_id")
        ) {
            $this->setRedirect('customer/account/login');
        }
    }
    public function registerAction()
    {
        $layout = $this->getLayout();
        $layout->removeChild('header');
        $layout->removeChild('footer');
        $child = $layout->getChild('content');
        $layout->getChild('head')->addCss('customer/form.css');

        $productForm = $layout->createBlock('customer/customer');
        $child->addChild('form', $productForm);

        $layout->toHtml();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams('customer');
        $product = Mage::getModel('customer/customer')
            ->setData($data)->save();
        $location = Mage::getBaseUrl('Customer/Account/login');
        header("location: $location");
    }
    public function loginAction()
    {
        if (!$this->getRequest()->isPost()) {
            $layout = $this->getLayout();
            $layout->removeChild('header');
            $layout->removeChild('footer');
            $child = $layout->getChild('content');
            $layout->getChild('head')->addCss('customer/loginForm.css');
            $productForm = $layout->createBlock('customer/login');
            $child->addChild('form', $productForm);
            $layout->toHtml();
        } else {
            $data = $this->getRequest()->getParams('login');
            $email = $data['customer_email'];
            $password = $data['password'];
            $customerCollection = Mage::getModel('customer/customer')->getCollection()->addFieldToFilter('customer_email', $email)->addFieldToFilter('password', $password);
            $count = 0;
            $customerId = 0;
            foreach ($customerCollection->getData() as $customer) {
                $count++;
                $customerId = $customer->getCustomerId();
            }
            if ($count == 1) {
                Mage::getSingleton('core/session')->set('logged_in_customer_id', $customerId);
                Mage::getSingleton('sales/quote')->initQuote();
                if (Mage::getSingleton('core/session')->get('set_back_url')) {
                    $this->setRedirect(Mage::getSingleton('core/session')->get('set_back_url'));
                } else {
                    $this->setRedirect('customer/account/dashboard');
                }
            } else {
                $this->setRedirect('customer/account/login');
            }
        }
    }
    public function logoutAction()
    {
        Mage::getSingleton('core/session')->unsetAll();
        $this->setRedirect("");
    }
    public function dashboardAction()
    {
        // $customerId = Mage::getSingleton('core/session')->get('logged_in_customer_id');
        $layout = $this->getLayout();
        $layout->getChild('head')->addCss('customer/dashboard.css');
        $child = $layout->getChild('content');
        $dashboard = $layout->createBlock("customer/dashboard");
        $child->addChild('dashboard', $dashboard);
        // $dashboard->setCustomerId($customerId);
        $layout->toHtml();
    }
    public function forgotPasswordAction()
    {
        $layout = $this->getLayout();
        $child = $layout->getChild('content');
        // $layout->getChild('head')->addCss('customer/form.css');

        $productForm = $layout->createBlock('customer/forgotpass');
        $child->addChild('form', $productForm);

        $layout->toHtml();
    }
}
?>