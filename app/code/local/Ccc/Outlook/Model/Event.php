<?php
class Ccc_Outlook_Model_Event extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/event');
    }
    public function saveData($eventData,$configModel){
        $configId = $configModel->getID();
        $groupId = $this->getCollection()
        ->addFieldToSelect('group_id')
        ->setOrder('group_id', 'Desc')
        ->getFirstItem()
        ->getGroupId();
        foreach($eventData as $event){
            $data['event'] = $event['eventName'];
            foreach($event['rows'] as $rule){
                $data['operator'] = $rule['operator_dropdown'];
                $data['value'] = $rule['value'];
                $data['condition'] = $rule['condition_dropdown'];
                $data['config_id'] = $configId;
                if(!empty($event['group_id'])){
                    $data['group_id'] = $event['group_id'];
                }
                else{
                    $groupId++;
                    $data['group_id'] = $groupId;
                }
                if(!isset($rule['event_id'])){
                    $this->setData($data)->save();
                }
            }
        }
    }
}
?>