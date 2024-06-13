<?php
class Ccc_Filetransfer_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getArray(){
        return array(
            'part_number'=>'items.item.itemIdentification::itemNumber',
            'depth'=>'items.item.itemIdentification::value',
            'length'=>'items.item.itemIdentification::value',
            'height'=>'items.item.itemIdentification::value',
            'weight'=>'items.item.itemIdentification::value',
        );
    }
}
?>