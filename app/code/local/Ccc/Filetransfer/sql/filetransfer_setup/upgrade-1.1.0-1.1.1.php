<?php
$installer = $this;
// echo get_class($installer);

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('filetransfer/file')) 
    ->addColumn('file_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'File ID')
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Config ID')
    ->addColumn('filename', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Filename')
    ->addColumn('received_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Received Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'Created At')
    ->addForeignKey(
        $installer->getFkName('filetransfer/file', 'config_id', 'filetransfer/configuration', 'config_id'),
        'config_id',
        $installer->getTable('filetransfer/configuration'),
        'config_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )->setComment('Filetrasfer Files');

$installer->getConnection()->createTable($table);

$installer->endSetup();
