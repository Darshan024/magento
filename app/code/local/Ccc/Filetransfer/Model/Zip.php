<?php
class Ccc_Filetransfer_Model_Zip extends ZipArchive
{
    public function extractFile($filename, $configId)
    {
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $filename;
        $extractTo = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . 'extracted' . DS . $basename;

        if ($this->open($filePath)) {
            $this->extractTo($extractTo);
        }
        $extractedFiles = glob($extractTo.DS.'*');
        $fileModel = Mage::getModel('filetransfer/file');
        
        foreach ($extractedFiles as $file) {
            $newFile = pathinfo($file, PATHINFO_BASENAME);
            $date = date('Y-m-d H:i:s', filemtime($extractTo . DS . $newFile));
            $fileData = [
                'config_id'=>$configId,
                'filename' => $basename.DS.$newFile,
                'received_time' => $date,
            ];
            $fileModel->setData($fileData)->save();
        }
    }
}