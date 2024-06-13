<?php
class Import_Model_Resource_Temp extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init('import_temp', 'import_id');
    }
}