<?php
class Ccc_Filemanager_Model_Resource_Filemanager_Collection extends Varien_Data_Collection_Filesystem
{
    protected $_directory;

    public function __construct()
    {
        parent::__construct();
    }
    protected function _generateRow($filename)
    {
        $relativePath = str_replace($this->_targetDirs, '', dirname($filename));  
        $relativePath=$relativePath===''?'/':$relativePath.'/';
        $creationTime = filectime($filename);
        $formattedDate = date('Y-m-d H:i:s', $creationTime);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        return array(
            'basepath'=>$filename,
            'filepath' => $relativePath,
            'basename' => $name,
            'date'=>$formattedDate,
            'extension'=>$extension,
        );
    }
}
?>