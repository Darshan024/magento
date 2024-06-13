<?php
class Ccc_Salesman_Block_Adminhtml_Rankreport_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ReportGrid');
        $this->setTemplate('salesman/rankreport/grid.phtml');
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        // echo '<pre>' ;
        $filter = $this->getParam($this->getVarNameFilter(), null);
        $data = $this->helper('adminhtml')->prepareFilterString($filter);

        $collection = Mage::getModel('salesman/ordercommision')->getCollection();
        $collection->getSelect()->join(
            array('u' => $collection->getTable('admin/user')),
            'main_table.user_id = u.user_id',
            array('username')
        );
        if (isset($data['date']['from']) && isset($data['date']['to'])) {
            $collection
                ->addFieldToFilter('main_table.created_at', array('gteq' => $data['date']['from']))
                ->addFieldToFilter('main_table.created_at', array('lteq' => $data['date']['to']));
        }
        $productMetric = Ccc_Salesman_Model_Salesman::METRIC_PRODUCT;
        $shippingMetric = Ccc_Salesman_Model_Salesman::METRIC_SHIPPING;
        $taxMetric = Ccc_Salesman_Model_Salesman::METRIC_TAX;
        $salesmanColumns = array(
            'user_id',
            'u.username',
            'SUM(commission) AS total_commission',
            "(SUM(CASE WHEN metric='{$productMetric}' THEN commission ELSE 0 END)) AS product_commission",
            "(SUM(CASE WHEN metric='{$shippingMetric}' THEN commission ELSE 0 END)) AS shipping_commission",
            "(SUM(CASE WHEN metric='{$taxMetric}' THEN commission ELSE 0 END)) AS tax_commission",
        );
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->columns(
                $salesmanColumns
            );
        $collection->getSelect()->group('main_table.user_id');
        // echo $collection->getSelect()->__toString()."<br>";
        // print_r($collection->getData());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/rankreportajax', ['_current' => true]);
    }
    public function getTotalRank($id)
    {
        $salesmanData = $this->getCollection();
        $rank = [];
        $today_rank = 1;
        $totalCommission = [];
        foreach ($salesmanData as $salesman) {
            $totalCommission[$salesman['user_id']] = $salesman['total_commission'];
        }
        arsort($totalCommission);
        foreach ($totalCommission as $key => $value) {
            $rank[] = [
                'user_id' => $key,
                'rank' => $today_rank,
                'commission' => $value,
            ];
            $today_rank++;
        }
        foreach ($rank as $key => $value) {
            if ($value['user_id'] == $id) {
                return "Rank " . $value['rank'] . " Total Commission " . $value['commission'];
            }
        }

    }
    public function getProductRank($id) 
    {
        $salesmanData = $this->getCollection();
        $rank = [];
        $today_rank = 1;
        $totalCommission = [];
        foreach ($salesmanData as $salesman) {
            $totalCommission[$salesman['user_id']] = $salesman['product_commission'];
        }
        arsort($totalCommission);
        foreach ($totalCommission as $key => $value) {
            $rank[] = [
                'user_id' => $key,
                'rank' => $today_rank,
                'commission' => $value,
            ];
            $today_rank++;
        }
        foreach ($rank as $key => $value) {
            if ($value['user_id'] == $id) {
                return "Rank " . $value['rank'] . " Product Commission " . $value['commission'];
            }
        }
    }
    public function getShippingRank($id)
    {
        $salesmanData = $this->getCollection();
        $rank = [];
        $today_rank = 1;
        $totalCommission = [];
        foreach ($salesmanData as $salesman) {
            $totalCommission[$salesman['user_id']] = $salesman['shipping_commission'];
        }
        arsort($totalCommission);
        foreach ($totalCommission as $key => $value) {
            $rank[] = [
                'user_id' => $key,
                'rank' => $today_rank,
                'commission' => $value,
            ];
            $today_rank++;
        }
        foreach ($rank as $key => $value) {
            if ($value['user_id'] == $id) {
                return "Rank " . $value['rank'] . " Shipping Commission " . $value['commission'];
            }
        }
    }
    public function getTaxRank($id)
    {
        $salesmanData = $this->getCollection();
        $rank = [];
        $today_rank = 1;
        $totalCommission = [];
        foreach ($salesmanData as $salesman) {
            $totalCommission[$salesman['user_id']] = $salesman['tax_commission'];
        }
        arsort($totalCommission);
        foreach ($totalCommission as $key => $value) {
            $rank[] = [
                'user_id' => $key,
                'rank' => $today_rank,
                'commission' => $value,
            ];
            $today_rank++;
        }
        foreach ($rank as $key => $value) {
            if ($value['user_id'] == $id) {
                return "Rank " . $value['rank'] . " Tax Commission " . $value['commission'];
            }
        }
    }
}
?>