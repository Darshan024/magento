<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('filetransfer/configuration')) 
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Config ID')
    ->addColumn('username', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Usernaem')
    ->addColumn('password', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Password')
    ->addColumn('host', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Host')
    ->addColumn('port', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => false
    ), 'Port')
    ->setComment('Filetrasfer Configuration');

$installer->getConnection()->createTable($table);

$installer->endSetup();
