<?php

$installer = $this;

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('outlook/event'))
    ->addColumn('event_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Event ID')
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Config ID')
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Group Id')
    ->addColumn('operator', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
    ), 'Operator')
    ->addColumn('condition', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false
    ), 'Condition')
    ->addColumn('event', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default' => 0
    ), 'Event')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'unsigned' => true,
    ), 'Value')
    
    ->setComment('Event Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
?>