<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('salesman_metric_percentage')) 
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Entity ID')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'User Id')
    ->addColumn('metric', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Metric')
    ->addColumn('percentage', Varien_Db_Ddl_Table::TYPE_FLOAT, 11, array(
        'nullable' => false
    ), 'Percentage')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), 'Updated At')
    ->setComment('Salesman Metric Percentage Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
