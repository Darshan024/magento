<?php
class Banner_Model_Banner extends Core_Model_Abstract
{

    public function init()
    {
        $this->_resourceClass = 'Banner_Model_Resource_Banner';
        $this->_collectionClass = 'Banner_Model_Resource_Collection_Banner';
        $this->_modelClass = 'banner/banner';
    }
    public function getStetus()
    {
        $mapping = [
            1 => "Enabled",
            0 => "Disabled"
        ];
        if (isset($this->_data['status'])) {
            return $mapping[$this->_data['status']];
        }
    }
    public function getActiveBanner()
    {
        $bannerList = Mage::getModel('banner/banner')->getCollection()
            ->addFieldToFilter('show_on', 'Homepage')->addFieldToFilter('status', 1); // Filter by status
        return $bannerList->getData();
    }
}
?>