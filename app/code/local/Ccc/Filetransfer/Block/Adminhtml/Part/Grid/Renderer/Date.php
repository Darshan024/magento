<?php
class Ccc_Filetransfer_Block_Adminhtml_Part_Grid_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row){
        $newPartDate = $row->getNewPartDate();
        $disPartDate = $row->getDisPartDate();
        if ($newPartDate) {
            return $newPartDate;
        } elseif ($disPartDate) {
            return $disPartDate;
        } else {
            return $row->getData('date');
        }
    }
}