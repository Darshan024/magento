<?php
$installer = $this;
// echo get_class($installer);

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('filetransfer/newpart')) 
    ->addColumn('new_part_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'New Part Numer ID')
    ->addColumn('part_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Part ID')
    ->addColumn('part_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Config ID')
    ->addColumn('new_part_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'New Part Date')
    ->setComment('Filetrasfer New Part Number');

$installer->getConnection()->createTable($table);

$installer->endSetup();
