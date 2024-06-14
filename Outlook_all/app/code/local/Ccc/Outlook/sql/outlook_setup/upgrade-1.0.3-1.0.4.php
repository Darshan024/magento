<?php

$installer = $this;

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('outlook/attachament'))
    ->addColumn('attachament_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Attachament ID')
    ->addColumn('filename', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'File Name')
    ->addColumn('path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Path')
    ->addColumn('outlook_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Outlook Id')
    ->addColumn('email_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false
    ), 'Email Id')
    ->addForeignKey(
        $installer->getFkName('outlook/attachament', 'email_id', 'outlook/email', 'email_id'),
        'email_id',
        $installer->getTable('outlook/email'),
        'email_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Attachament Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
?>