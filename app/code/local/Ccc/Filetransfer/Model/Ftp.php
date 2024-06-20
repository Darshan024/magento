<?php
class Ccc_Filetransfer_Model_Ftp extends Varien_Io_Ftp
{
    protected $_configObj;
    public function fetchAllfiles()
    {
        $configModel = $this->_configObj;
        $username = $configModel->getUsername();
        $host = $configModel->getHost();
        $password = $configModel->getPassword();
        $connection = $this->open(
            array(
                'host' => $host,
                'user' => $username,
                'password' => $password,
            )
        );
        $filesData = [];
        if ($connection) {
            $allFiles = $this->getRecursiveFiles($this->pwd());
            foreach ($allFiles as $file) {
                $fileName = basename($file['name']);

                $relativepath = $file['relative_path'];

                $timestamp = date('Ymd_His');

                $localFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $localFilePath = Mage::getBaseDir('var') . DS . 'filetransfer' .DS. ltrim($relativepath,'/') . DS . $localFileName;
                
                if (!file_exists(dirname($localFilePath))) {
                    mkdir(dirname($localFilePath), 0755, true);
                }

                $this->read($file['path'], $localFilePath);

                $modTime = filemtime($localFilePath);
                $receivedTime = ($modTime !== false) ? date('Y-m-d H:i:s', $modTime) : null;

                
                $this->mv(($file['path']), 'completed' . DS . $localFileName);

                $filesData[] = [
                    'filename' => $localFileName,
                    'received_time' => $receivedTime,
                ];
            }
        }
        $this->close();
        // print_r($filesData);
        return $filesData;
    }
    public function setConfigObj($config)
    {
        $this->_configObj = $config;
    }
    public function getRecursiveFiles($path, $relativePath = '')
    {
        $allFiles = [];
        $this->cd($path);
        $fileList = $this->ls();

        foreach ($fileList as $file) {
            if ($file['text'] == '.' || $file['text'] == '..' || basename($file['text']) == 'completed') {
                continue;
            }

            $itemPath = $path . '/' . $file['text'];
            $itemRelativePath =ltrim($relativePath .'/'.$file['text'] , '/');

            if ($this->cd($itemPath)) {
                $allFiles = array_merge($allFiles, $this->getRecursiveFiles($itemPath, $itemRelativePath));
                $this->cd($path);
            } else {
                $allFiles[] = [
                    'path' => $itemPath,
                    'name' => $file['text'],
                    'relative_path' => $relativePath,
                ];
            }
        }
        return $allFiles;
    }
}
?>