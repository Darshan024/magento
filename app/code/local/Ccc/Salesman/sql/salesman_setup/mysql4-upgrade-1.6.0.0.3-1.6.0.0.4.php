<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('salesman/ordercommision')}
CHANGE `created_at` `created_at` date NOT NULL;
");
$installer->run("
ALTER TABLE {$this->getTable('salesman/ordercommision')}
CHANGE `updated_at` `updated_at` date NOT NULL;
");
$installer->endSetup();
