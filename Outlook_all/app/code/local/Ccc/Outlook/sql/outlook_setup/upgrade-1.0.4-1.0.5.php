<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('outlook/configuration');

$installer->getConnection()
    ->addColumn($tableName,'last_read_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false,
    ), 'Last Read Time');
    
$installer->endSetup();

?>