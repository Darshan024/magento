<?php
class Import_Model_Temp extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClass = "Import_Model_Resource_Temp";
        $this->_collectionClass = "Import_Model_Resource_Collection_Temp";
        $this->_modelClass = "import/temp";
    }
}