<?php
class Ccc_Outlook_Model_Observer
{
    public function fetch()
    {
        $configCollection = Mage::getModel('outlook/configuration')->getCollection();
        foreach ($configCollection as $config) {
            $config->fetchEmails();
        }
    }
    public function checkDispatchEvent(Varien_Event_Observer $observer)
    {
        $data = $observer->getEmail();
        Mage::log($data->getData(),null,'event_check.log',true);
    }
}
?>