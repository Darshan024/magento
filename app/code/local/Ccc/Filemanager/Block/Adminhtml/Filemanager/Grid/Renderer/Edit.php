<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Grid_Renderer_Edit extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $html = '<span class="editable" data-basepath="' . $row->getBasepath() . '" data-basename="' . $row->getBasename(). '" onclick="filemanagerJsObject.inlineedit(event)" >' . ($value) . '</span>';
        return $html;
    }
}
?>