<?php

require_once 'app/code/local/Ccc/Salesman/controllers/Adminhtml/SalesmanController.php';

class Ccc_Test_Adminhtml_SalesmanController extends Ccc_Salesman_Adminhtml_SalesmanController
{
    public function indexAction()
    {
        echo 123;
    }
}

?>