<?php
class Ccc_Salesman_Block_Adminhtml_Report_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public $_totalUpsold = 0;

    public function render(Varien_Object $row)
    {
        $functionToCall = $this->getColumn()->getFunctionToCall();
        switch ($functionToCall) {
            case 'getformto':
                return $this->getformto($row);
            default:
                return parent::render($row);
        }
    }
    public function getformto($row){
         $html = '<input type="text" name="filter[' . $this->getColumn()->getId() . '][from]" class="input-text" />';
        $html .= '<input type="text" name="filter[' . $this->getColumn()->getId() . '][to]" class="input-text" />';
        return $html;
    }
    
}
