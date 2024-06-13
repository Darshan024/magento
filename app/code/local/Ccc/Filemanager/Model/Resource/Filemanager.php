<?php
class Ccc_Filemanager_Model_Resource_Filemanager extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('filemanager/filemanager', 'file_id');
    }
}
?>