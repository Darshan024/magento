<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('ticket/status')) 
    ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Status ID')
    ->addColumn('status_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Status Code')
    ->addColumn('status_label', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Status Label')
    ->addColumn('colour_code', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => false
    ), 'Colour Code')
    ->setComment('Ticket Status ');

$installer->getConnection()->createTable($table);

$installer->endSetup();
