<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $id = $row->getId();
        $html = '<span id="editable_' . $this->getColumn()->getId() . '_' . $id . '" class="editable" data-id="' . $id . '" data-column="' . $this->getColumn()->getId() . '">' . htmlspecialchars($value) . '</span>';
        return $html;
    }
}
?>