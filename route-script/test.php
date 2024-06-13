<?php
require_once ('../app/Mage.php');
Mage::app();
echo "<pre>";
// Mage::getModel('outlook/observer')->fetch();
// Mage::getModel('outlook/observer')->checkDispatchEvent();
Mage::getModel('filetransfer/observer')->fetchfile();