<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('ticket/ticket')) 
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Ticket ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Title')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Password')
    ->addColumn('assign_by', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Assign By')
    ->addColumn('assign_to', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => false
    ), 'Assign To')
    ->addColumn('priority', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => false
    ), 'Priority')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR,255, array(
        'nullable' => false
    ), 'Status')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'Updated At')
    ->setComment('Ticket Information');

$installer->getConnection()->createTable($table);

$installer->endSetup();
