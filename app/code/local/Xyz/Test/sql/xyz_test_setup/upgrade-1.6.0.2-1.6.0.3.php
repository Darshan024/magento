<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('banner/banner');

$installer->getConnection()
    ->addColumn(
        $tableName,
        'test',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 255,
            'comment' => 'Test'
        )
    );
$installer->endSetup();
?>
