<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('Mostsellingrelateditems/mostsellproduct')) 
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('most_selling_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Most Selling Product Id')
    ->addColumn('related_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false
    ), 'Related Product Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false
    ), '')
    ->addColumn('is_delated', Varien_Db_Ddl_Table::TYPE_INTEGER,11, array(
        'nullable' => false
    ), 'Is Delated')
    ->addColumn('deleted_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'Delated At')
    ->setComment('Filetrasfer Configuration');

$installer->getConnection()->createTable($table);

$installer->endSetup();
