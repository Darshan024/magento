<?php
class Ccc_Filetransfer_Adminhtml_FileController extends Mage_Adminhtml_Controller_Action
{
    public function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('filetransfer');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Filetransfer'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function extractAction()
    {
        $filename = $this->getRequest()->getParam('filename');
        $ConfigId = $this->getRequest()->getParam('config_id');
        $zipModel = Mage::getModel('filetransfer/zip');
        $zipModel->extractFile($filename, $ConfigId);
        $this->_redirect('*/*/index');
    }
    public function exportAction()
    {
        $filename = str_replace('_', '\\', $this->getRequest()->getParam('filename'));

        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . 'extracted' . DS . $filename;

        $xml = simplexml_load_file($filePath);

        $data = [];
        $xmlRows = Mage::helper('filetransfer')->getArray();

        foreach ($xmlRows as $key => $value) {
            $parts = explode('::', $value);
            $path = $parts[0];
            $attribute = $parts[1];

            $elements = $xml->xpath(str_replace('.', '/', $path));
            foreach ($elements as $element) {
                if ($key == 'part_number') {
                    $identifiers = [];
                    foreach ($element->xpath('.//itemIdentifier') as $identifier) {
                        $identifiers = (string) $identifier[$attribute];
                    }
                    $data[$key][] =$identifiers;
                } elseif ($key == "depth" || $key == "length" || $key == "height" || $key == "weight") {
                    $dimesnsions = [];
                    foreach ($element->xpath(".//itemCharacteristics/itemDimensions/$key") as $dimesnsion) {
                        $dimesnsions = (string) $dimesnsion[$attribute];
                    }
                    $data[$key][] = $dimesnsions;
                }
            }
        }
        $maxRows = array_map('count', $data);
        $csvData = [];
        for ($i = 0; $i < max($maxRows); $i++) {
            $row = [];
            foreach (array_keys($data) as $key) {
                $row[$key] = $data[$key][$i];
            }
            $csvData[] = $row;
        }
        $partModel = Mage::getModel('filetransfer/part');
        foreach($csvData as $data){
            $partModel->setData($data)->save();
        }
        // $this->_redirect('*/*/index');
    }
}
?>