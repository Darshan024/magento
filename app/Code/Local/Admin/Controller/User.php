<?php
class Admin_Controller_User extends Core_Controller_Admin_Action
{
    protected $_allowedActions = ['login'];
    public function loginAction()
    {
        if (!$this->getRequest()->isPost()) {
            $layout = $this->getLayout();
            $layout->removeChild('header');
            $layout->removeChild('footer');
            $child = $layout->getChild('content');
            $layout->getChild('head')->addCss('admin/form.css');
            $productForm = $layout->createBlock('admin/form');
            $child->addChild('form', $productForm);
            $layout->toHtml();
        } else {
            $data = $this->getRequest()->getParams('login');
            $email = $data['customer_email'];
            $password = $data['password'];
            $pass = 123;
            $adminEmail = 'darshan@gmail.com';
            if ($password == $pass && $adminEmail == $email) {
                Mage::getSingleton('core/session')->set('logged_in_admin_user_id', 1);
                $this->setRedirect('admin');
            } else {
                $this->setRedirect('admin/user/login');
            }
        }
    }
    public function logoutAction()
    {
        Mage::getSingleton('core/session')->unsetAll();
        $this->setRedirect("");
    }
}
?>