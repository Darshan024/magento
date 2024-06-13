<?php
class Admin_Controller_Import extends Core_Controller_Admin_Action
{
    public function formAction()
    {
        $layout = $this->getLayout();
        $layout->getChild("head")->addCss("import/form.css");
        $banner = $layout->createBlock("import/form");
        $layout->getChild("content")
            ->addChild('form', $banner);
        $layout->toHtml();
    }
    public function saveAction()
    {
        if (isset($_POST['submit'])) {
            $fileData = $_FILES['import_file']['name'];
            $tmp_name = $_FILES['import_file']['tmp_name'];
            $folder = "media/import/" . $fileData;
            move_uploaded_file($tmp_name, $folder);
        }
        $this->setRedirect('admin/import/list');
    }
    public function listAction()
    {
        $layout = $this->getLayout();
        $layout->getChild("head")->addCss("import/list.css");
        $banner = $layout->createBlock("import/list");
        $layout->getChild("content")
            ->addChild('list', $banner);
        $layout->toHtml();
    }
    public function readAction()
    {
        $files = $this->getRequest()->getParams('file');
        $file = Mage::getBaseDir('media/import/') . $files;

        $file = fopen($file, 'r');
        $column = fgetcsv($file);
        while ($data = fgetcsv($file)) {
            $data = array_combine($column, $data);
            $data = json_encode($data);
            Mage::getModel('import/import')
                ->addData('json_data', $data)
                ->addData('csv_name', $files)
                ->addData('type', 'product')
                ->save();
        }
        fclose($file);
        $this->setRedirect('admin/import/readedlist');
    }
    public function readedlistAction()
    {
        $layout = $this->getLayout();
        $layout->getChild("head")
            ->addCss("import/list.css");
        $layout->getChild("head")
            ->addJs("import/list.js");
        $banner = $layout->createBlock("import/readedlist");
        $layout->getChild("content")
            ->addChild('readedlist', $banner);
        $layout->toHtml();
    }
    public function importAction()
    {
        $type = $this->getRequest()->getParams('type');
        $importItem = Mage::getModel('import/import')
            ->getCollection()
            ->addFieldToFilter('type', $type)
            ->addFieldToFilter('status', 0)
            ->getFirstItem();
        $product = Mage::getModel('catalog/product')
            ->setData(json_decode($importItem->getJsonData(), true))
            ->save()
            ->getId();
        if ($product) {
            $importItem->addData('status', 1)->save();
            echo "true";
        } else {
            echo "false";
        }
    }
    // public function uploadAction()
    // {
    //     if (isset ($_POST['submit'])) {
    //         $fileName = $_FILES['csv_file']['name'];
    //         $tmp_name = $_FILES['csv_file']['tmp_name'];
    //         $folder = "media/import/" . $fileName;
    //         move_uploaded_file($tmp_name, $folder);
    //     }
    //     $this->setRedirect('admin/import/index');
    // }
    // public function readAction()
    // {
    //     $path = Mage::getBaseUrl('media/import/test.csv');
    //     $row = 1;
    //     if (($handle = fopen($path, "r")) !== FALSE) {
    //         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //             if ($row == 1) {
    //                 // print_r($data);
    //                 $header = $data;
    //                 $row++;
    //                 continue;
    //             }
    //             $data1 = array_combine($header, $data);
    //             $data1 = json_encode($data1);
    //             Mage::getModel('import/import')->addData('data', $data1)->addData('csv_name', 'test.csv')
    //                 ->save();
    //             $row++;
    //             $num = count($data);
    //             echo "<p> $num fields in line $row: <br /></p>\n";
    //             $row++;
    //             for ($c = 0; $c < $num; $c++) {
    //                 echo $data[$c] . "<br />\n";
    //             }
    //         }
    //         fclose($handle);
    //     }
    //     echo "file read done";
    //     $this->setRedirect('admin/import/index');
    // }
    // public function importAction()
    // {
    //     $data = Mage::getModel('import/import')
    //         ->getCollection()
    //         ->addFieldToFilter('csv_name', 'test.csv');
    //     foreach ($data->getData() as $data1) {
    //         $fileData = $data1->getData();
    //         $importData = $fileData['data'];
    //         $importData = json_decode($importData, true);
    //         Mage::getModel('import/temp')->setData($importData)->save();
    //         echo 'save';
    //         $data1->adddata('status', 1)->save();
    //     }
    //     echo "file import done";
    //     $this->setRedirect('admin/import/index');
    // }
}