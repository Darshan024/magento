<?php
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('ticket/filter');
if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('filter_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Filter Id')
        ->addColumn('filter_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Filter Name')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable' => false,
        ), 'Status')
        ->addColumn('assign_to', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable' => false,
        ), 'Assign To')
        ->addColumn('create_at', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'nullable' => false,
        ), 'Created At')
        ->addColumn('lastcomment', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable' => false,
        ), 'Last Commented By')
        ->setComment('Ccc Ticket Filter Table');
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();