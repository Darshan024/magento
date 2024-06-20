<?php
class Ccc_Filetransfer_Model_Observer
{
    public function fetchfile()
    {
        $configCollection = Mage::getModel('filetransfer/configuration')->getCollection();
        foreach ($configCollection as $config) {
            $config->savefile();
        }
    }
    public function fetchXmlData()
    {
        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . 'extracted' . DS . 'short.xml';

        $xml = simplexml_load_file($filePath);

        $data = [];
        $xmlRows = Mage::helper('filetransfer')->getArray();

        foreach ($xmlRows as $key => $value) {
            $parts = explode('::', $value);
            $path = $parts[0];
            $attribute = $parts[1];

            $elements = $xml->xpath(str_replace('.', '/', $path));
            foreach ($elements as $element) {
                if ($key == 'part_number') {
                    $identifiers = [];
                    foreach ($element->xpath('.//itemIdentifier') as $identifier) {
                        $identifiers = (string) $identifier[$attribute];
                    }
                    $data[$key][] = $identifiers;
                } elseif ($key == "depth" || $key == "length" || $key == "height" || $key == "weight") {
                    $dimesnsions = [];
                    foreach ($element->xpath(".//itemCharacteristics/itemDimensions/$key") as $dimesnsion) {
                        $dimesnsions = (string) $dimesnsion[$attribute];
                    }
                    $data[$key][] = $dimesnsions;
                }
            }
        }

        $maxRows = array_map('count', $data);
        $xmlData = [];
        for ($i = 0; $i < max($maxRows); $i++) {
            $row = [];
            foreach (array_keys($data) as $key) {
                $row[$key] = $data[$key][$i];
            }
            $xmlData[] = $row;
        }
        $this->saveXmlData($xmlData);
    }
    public function saveXmlData($xmlData)
    {
        $xmlPartNumbers = [];
        $oldPartNumbers = [];

        foreach ($xmlData as $xmlRow) {
            $xmlPartNumbers[] = $xmlRow['part_number'];
        }

        $partModel = Mage::getModel('filetransfer/part');
        $oldData = $partModel->getCollection()->getData();

        foreach ($oldData as $oldRow) {
            $oldPartNumbers[$oldRow['entity_id']] = $oldRow['part_number'];
        }

        $newPartData = [];
        foreach ($xmlData as $xmlRow) {
            $partNumber = $xmlRow['part_number'];
            if (!in_array($partNumber, $oldPartNumbers)) {
                $partModel->setData($xmlRow)->save();
                $masterPartId = $partModel->getId();
                $newPartData[] = [
                    'part_id' => $masterPartId,
                    'part_number' => $partNumber
                ];
            } else {
                $existingPartId = array_search($partNumber, $oldPartNumbers);
                $partModel->load($existingPartId)->addData($xmlRow)->save();
            }
        }

        $discontinueData = array_diff($oldPartNumbers, $xmlPartNumbers);

        if (!empty($newPartData)) {
            $this->saveNewPartData($newPartData);
        }
        $this->saveDiscontinueData($discontinueData);
    }
    public function saveNewPartData($newPartData)
    {
        $resource = Mage::getSingleton('core/resource');
        $connection = $resource->getConnection('core_write');
        $newPartTable = $resource->getTableName('filetransfer/newpart');
        $connection->insertMultiple($newPartTable, $newPartData);
    }

    public function saveDiscontinueData($discontinueData)
    {
        $resource = Mage::getSingleton('core/resource');
        $connection = $resource->getConnection('core_write');
        $disPartTable = $resource->getTableName('filetransfer/dispart');

        $data = [];
        foreach ($discontinueData as $key => $value) {
            $data[] = [
                'part_id' => $key,
                'part_number' => $value,
            ];
        }
        if (!empty($data)) {
            $connection->insertMultiple($disPartTable, $data);
        }
    }


}