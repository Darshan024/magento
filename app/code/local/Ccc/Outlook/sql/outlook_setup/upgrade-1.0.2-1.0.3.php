<?php

$installer = $this;

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('outlook/email'))
    ->addColumn('email_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Email ID')
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Config ID')
    ->addColumn('from', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Email From')
    ->addColumn('to', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Email To')
    ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Email Subject')
    ->addColumn('received_datetime', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Email Received Time')
    ->addColumn('has_attechments', Varien_Db_Ddl_Table::TYPE_TINYINT, 2, array(
        'nullable' => false,
        'default' => 0
    ), 'Email Has Attechments')
    ->addColumn('body', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'unsigned' => true,
    ), 'Email Body')
    ->addColumn('outlook_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'unsigned' => true,
    ), 'Attachment ID')
    ->addForeignKey(
        $installer->getFkName('outlook/email', 'config_id', 'outlook/configuration', 'config_id'),
        'config_id',
        $installer->getTable('outlook/configuration'),
        'config_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Email Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
?>