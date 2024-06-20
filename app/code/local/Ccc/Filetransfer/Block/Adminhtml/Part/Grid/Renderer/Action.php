<?php
class Ccc_Filetransfer_Block_Adminhtml_Part_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row){
        $newPartId = $row->getData('new_part_id');
        $disPartId = $row->getData('dis_part_id');

        if ($newPartId) {
            return 'New Part number';
        } elseif ($disPartId) {
            return 'Discontinued Part number';
        } else {
            return 'Regular';
        }
    }
}