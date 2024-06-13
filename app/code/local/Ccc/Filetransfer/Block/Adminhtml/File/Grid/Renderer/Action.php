<?php
class Ccc_Filetransfer_Block_Adminhtml_File_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $fileName = $row->getFilename();
        if (pathinfo($fileName, PATHINFO_EXTENSION) == 'zip') {
            $extractUrl = $this->getUrl('*/*/extract', array('filename' => $row->getFilename(), 'config_id' => $row->getConfigId()));
            $html = '<a href="' . $extractUrl . '"><button>Extract</button></a>';
            return $html;
        }
        elseif(pathinfo($fileName, PATHINFO_EXTENSION) == 'xml'){
            $fileName = str_replace('\\','_',$row->getFilename());
            $exportUrl = $this->getUrl('*/*/export', array('filename' => $fileName));
            $html = '<a href="' . $exportUrl . '"><button>Export CSV</button></a>';
            return $html;
        }
        return '';
    }
}
?>