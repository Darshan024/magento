<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $deleteUrl = $this->getUrl('*/*/delete') . "?filepath=" . $row->getBasepath();
        $downloadUrl = $this->getUrl('*/*/download') . "?filepath=" . $row->getBasepath();
        $html = '<a href="' . $downloadUrl . '"><button>Download</button></a>';
        $html .= '&nbsp;';
        $html .= '<a href="' . $deleteUrl . '"><button>Delete</button></a>';
        return $html;
    }
}
?>