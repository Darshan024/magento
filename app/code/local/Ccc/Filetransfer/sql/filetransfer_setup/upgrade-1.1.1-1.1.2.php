<?php
$installer = $this;
// echo get_class($installer);

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('filetransfer/part')) 
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Entity ID')
    ->addColumn('part_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Config ID')
    ->addColumn('depth', Varien_Db_Ddl_Table::TYPE_DOUBLE, null, array(
        'nullable' => false,
    ), 'Depth')
    ->addColumn('length', Varien_Db_Ddl_Table::TYPE_DOUBLE, null, array(
        'nullable' => false
    ), 'Length')
    ->addColumn('length', Varien_Db_Ddl_Table::TYPE_DOUBLE,null, array(
        'nullable' => false
    ), 'Length')
    ->addColumn('weight', Varien_Db_Ddl_Table::TYPE_DOUBLE,null, array(
        'nullable' => false
    ), 'Weight')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => false
    ), 'Status')
    ->addColumn('date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'Date')
    ->setComment('Filetrasfer Part Number');

$installer->getConnection()->createTable($table);

$installer->endSetup();
