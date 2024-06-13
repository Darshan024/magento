<?php
class Mage_Eav_Model_Entity_Attribute_Source_Promotion extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{
    public function getAllOptions(){
        $a = [];
        $collection = Mage::getModel('adminloginlog/promotion')->getCollection();
        foreach($collection->getData() as $data){
            $a[$data['percentage']] = $data['tag_name'];
        }
        return $a;
    }
}
?>