<?php
$installer = $this;
// echo get_class($installer);

$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('filetransfer/dispart')) 
    ->addColumn('dis_part_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Dis Part Numer ID')
    ->addColumn('part_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Part ID')
    ->addColumn('part_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Config ID')
    ->addColumn('dis_part_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP,null, array(
        'nullable' => false
    ), 'Discountinue Part Date')
    ->setComment('Filetrasfer Discountinue Part Number');

$installer->getConnection()->createTable($table);

$installer->endSetup();
