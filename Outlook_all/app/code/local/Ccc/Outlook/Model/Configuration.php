<?php
class Ccc_Outlook_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/configuration');
    }
    public function fetchEmails()
    {
        $lastRead = '';
        $apiModel = Mage::getModel('outlook/api');
        $apiModel->setConfigObj($this);
        $allEmails = $apiModel->getEmails();
        $emailModel = Mage::getModel('outlook/email');
        $emailModel->setConfigObj($this);
        foreach ($allEmails as $email) {
            $emailModel->setData($email)->save();
            if ($emailModel->getHasAttechments()) {
                $emailModel->fetchandsaveAttachaments();
            }
            $lastRead = $email['received_datetime'];
            $this->emailsFilter($emailModel);
        }
        $this->setData('last_read_time',$lastRead)->save();

    }
    public function emailsFilter($emailModel)
    {
        $eventsData = Mage::getModel('outlook/event')
            ->getCollection()
            ->addFieldToFilter('config_id', $emailModel->getConfigId());
        $groupIdArr = [];
        foreach ($eventsData as $event) {
            $groupIdArr[$event->getGroupId()][] = $event->getData();
        }
        foreach ($groupIdArr as $groupId => $groupData) {
            foreach ($groupData as $data) {
                $condition = $data['condition'];
                $operator = $data['operator'];
                $value = $data['value'];
                $eventName = $data['event'];
                $emailMatchesCondition = false;
                if ($condition == 'subject') {
                    $subject = $emailModel->getSubject();
                    $emailMatchesCondition = $this->applyCondition($subject, $operator, $value);
                } elseif ($condition == 'from') {
                    $from = $emailModel->getFrom();
                    $emailMatchesCondition = $this->applyCondition($from, $operator, $value);
                }
            }
            if ($emailMatchesCondition) {
                Mage::dispatchEvent($eventName, ['email' => $emailModel]);
            }
        }
    }
    private function applyCondition($fieldValue, $operator, $expectedValue)
    {
        switch ($operator) {
            case 'like':
                return stripos($fieldValue, $expectedValue) === 0;
            case '%like%':
                return stripos($fieldValue, $expectedValue) !== false; 
            case '==':
                return $fieldValue == $expectedValue;
            default:
                return false;
        }
    }
}
?>