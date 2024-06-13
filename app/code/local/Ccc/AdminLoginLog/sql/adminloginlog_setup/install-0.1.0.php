<?php
$installer = $this;
$installer->startSetup();

$installer->run("
    CREATE TABLE {$installer->getTable('adminloginlog/log')} (
        `log_id` int(11) unsigned NOT NULL auto_increment,
        `admin_user_id` int(10) unsigned NOT NULL,
        `login_at` datetime NOT NULL,
        PRIMARY KEY (`log_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
