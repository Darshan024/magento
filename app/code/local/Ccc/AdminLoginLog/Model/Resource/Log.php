<?php
class Ccc_AdminLoginLog_Model_Resource_Log extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('adminloginlog/log', 'log_id');
    }
}
