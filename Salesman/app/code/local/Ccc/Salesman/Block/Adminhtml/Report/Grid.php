<?php
class Ccc_Salesman_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ReportGrid');
        $this->setTemplate('salesman/commission/grid.phtml');
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        // echo "<pre>";
        $filter = $this->getParam($this->getVarNameFilter(), null);
        $data = $this->helper('adminhtml')->prepareFilterString($filter);

        // print_r(base64_decode($filter));
        // print_r($data);

        $collection = Mage::getModel('salesman/ordercommision')->getCollection();

        $collection->getSelect()->join(
            array('o' => $collection->getTable('sales/order')),
            'main_table.order_id = o.entity_id',
            array('created_at', 'increment_id', 'customer_firstname')
        );
        $collection->addFilterToMap('created_at', 'main_table.created_at');
        $collection->getSelect()->group('main_table.order_id');
        $collection->getSelect()->join(
            array('u' => $collection->getTable('admin/user')),
            'main_table.user_id = u.user_id',
            array('username')
        );
        if (isset($data['salesman']) && isset($data['date']['from']) && isset($data['date']['to'])) {
            $collection->addFieldToFilter('main_table.user_id', array('in' => $data['salesman']))
                ->addFieldToFilter('main_table.created_at', array('gteq' => $data['date']['from']))
                ->addFieldToFilter('main_table.created_at', array('lteq' => $data['date']['to']));
        } else {
            if (!Mage::getSingleton('admin/session')->isAllowed('salesman/salesman_commission/select_salesman')) {
                $userId = Mage::getSingleton('admin/session')->getUser()->getId();
                $collection->addFieldToFilter('main_table.user_id', $userId);
            } else {
                $collection->addFieldToFilter('main_table.user_id', 0);
            }
        }
        $productMetric = Ccc_Salesman_Model_Salesman::METRIC_PRODUCT;
        $shippingMetric = Ccc_Salesman_Model_Salesman::METRIC_SHIPPING;
        $taxMetric = Ccc_Salesman_Model_Salesman::METRIC_TAX;
        $salesmanColumns = array(
            'user_id',
            'u.username',
            'COUNT(distinct order_id) AS upsold_orders',
            "SUM(CASE WHEN metric='{$productMetric}' THEN upsold ELSE 0 END) AS product_upsold",
            "SUM(CASE WHEN metric='{$shippingMetric}' THEN upsold ELSE 0 END) AS shipping_upsold",
            "SUM(CASE WHEN metric='{$taxMetric}' THEN upsold ELSE 0 END) AS tax_upsold",
            'SUM(upsold) AS total_upsold',
            'SUM(commission) AS total_commission',
            'o.increment_id AS increment_id',
            'o.customer_firstname AS customer_firstname',
            'created_at AS created_at',
            'is_paid',
        );
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->columns(
                $salesmanColumns
            );
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('salesman')->__('Date'),
                'align' => 'left',
                'index' => 'created_at',
                'type' => 'date'
            )
        );
        $this->addColumn(
            'salesman_name',
            array(
                'header' => Mage::helper('salesman')->__('Salesman Name'),
                'index' => 'username',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'order_number',
            array(
                'header' => Mage::helper('salesman')->__('Order Number'),
                'align' => 'left',
                'index' => 'increment_id'
            )
        );
        $this->addColumn(
            'customer',
            array(
                'header' => Mage::helper('salesman')->__('Customer Name'),
                'align' => 'left',
                'index' => 'customer_firstname',
            )
        );
        $this->addColumn(
            'product_metric',
            array(
                'header' => Mage::helper('salesman')->__('Product Upsold'),
                'index' => 'product_upsold',
                'type' => 'currency',
                'currency_code' => Mage::app()->getStore()->getBaseCurrencyCode(),
                'align' => 'left',
                'filter_condition_callback' => array($this, '_filterProductUpsold')
            )
        );
        $this->addColumn(
            'shipping_metric',
            array(
                'header' => Mage::helper('salesman')->__('Shipping Upsold'),
                'index' => 'shipping_upsold',
                'type' => 'currency',
                'currency_code' => Mage::app()->getStore()->getBaseCurrencyCode(),
                'align' => 'left',
                'filter_condition_callback' => array($this, '_filterShippingUpsold')
            )
        );
        $this->addColumn(
            'tax_metric',
            array(
                'header' => Mage::helper('salesman')->__('Tax Upsold'),
                'index' => 'tax_upsold',
                'type' => 'currency',
                'currency_code' => Mage::app()->getStore()->getBaseCurrencyCode(),
                'align' => 'left',
                'filter_condition_callback' => array($this, '_filterTaxUpsold')
            )
        );
        if (Mage::getSingleton('admin/session')->isAllowed('salesman/salesman_commission/columns/total_upsold')) {
            $this->addColumn(
                'total_upsold',
                array(
                    'header' => Mage::helper('salesman')->__('Total Upsold'),
                    'index' => 'total_upsold',
                    'type' => 'currency',
                    'currency_code' => Mage::app()->getStore()->getBaseCurrencyCode(),
                    'align' => 'left',
                    'filter_condition_callback' => array($this, '_filterTotalUpsold')
                )
            );
        }
        if (Mage::getSingleton('admin/session')->isAllowed('salesman/salesman_commission/columns/commission')) {
            $this->addColumn(
                'commission',
                array(
                    'header' => Mage::helper('salesman')->__('Commission'),
                    'index' => 'total_commission',
                    'type' => 'currency',
                    'currency_code' => Mage::app()->getStore()->getBaseCurrencyCode(),
                    'align' => 'left',
                    'filter_condition_callback' => array($this, '_filterCommission')
                )
            );
        }
        $this->addColumn(
            'is_paid',
            array(
                'header' => Mage::helper('salesman')->__('Is Paid'),
                'index' => 'is_paid',
                'align' => 'left',
                'type' => 'options',
                'options' => array(
                    0 => 'Not Paid',
                    1 => 'Paid',
                )
            )
        );
        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    protected function _filterProductUpsold($collection, $column)
    {
        return $this->_filterByMetric($collection, $column, Ccc_Salesman_Model_Salesman::METRIC_PRODUCT);
    }
    protected function _filterShippingUpsold($collection, $column)
    {
        return $this->_filterByMetric($collection, $column, Ccc_Salesman_Model_Salesman::METRIC_SHIPPING);
    }
    protected function _filterTaxUpsold($collection, $column)
    {
        return $this->_filterByMetric($collection, $column, Ccc_Salesman_Model_Salesman::METRIC_TAX);
    }
    protected function _filterByMetric($collection, $column, $metric)
    {
        // echo $collection->getSelect()->__toString();
        $value = $column->getFilter()->getValue();
        if (isset($value['from']) && $value['from'] !== '') {
            $collection->getSelect()->having("SUM(CASE WHEN metric = '{$metric}' THEN upsold ELSE 0 END) >= '{$value['from']}'");
        }
        if (isset($value['to']) && $value['to'] !== '') {
            $collection->getSelect()->having("SUM(CASE WHEN metric = '{$metric}' THEN upsold ELSE 0 END) <= '{$value['to']}'");
        }
        // if (isset($value['from']) && isset($value['to']) && $value['from'] !== '' && $value['to'] !== '') {
        //     $collection->getSelect()->having('SUM(CASE WHEN metric="shipping" THEN upsold ELSE 0 END) >= ? AND <=??? ', $value['from'], $value['to']);
        // }

        return $this;
    }
    protected function _filterTotalUpsold($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (isset($value['from']) && $value['from'] !== '') {
            $collection->getSelect()->having('SUM(upsold) >= ?', $value['from']);
        }
        if (isset($value['to']) && $value['to'] !== '') {
            $collection->getSelect()->having('SUM(upsold) <= ?', $value['to']);
        }
        return $this;
    }
    protected function _filterCommission($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (isset($value['from']) && $value['from'] !== '') {
            $collection->getSelect()->having('SUM(commission) >= ?', $value['from']);
        }
        if (isset($value['to']) && $value['to'] !== '') {
            $collection->getSelect()->having('SUM(commission) <= ?', $value['to']);
        }
        return $this;
    }
    public function getSalesmanData()
    {
        $Collection = $this->getCollection();
        $salesmanData = [];
        foreach ($Collection->getData() as $item) {
            $userId = $item['user_id'];
            if (!isset($salesmanData[$userId])) {
                $salesmanData[$userId] = [
                    'user_id' => $userId,
                    'username' => '',
                    'upsold_orders' => 0,
                    'product_upsold' => 0,
                    'shipping_upsold' => 0,
                    'total_order' => 0,
                    'order_with_upsold' => 0,
                    'total_upsold' => 0,
                    'avg_upsold' => 0,
                    'total_commission' => 0,
                    'avg_commission' => 0,
                    'tax_upsold' => 0,
                ];
            }
            if ($item['total_upsold'] > 0) {
                $salesmanData[$userId]['order_with_upsold']++;
            }
            $salesmanData[$userId]['total_order'] += $item['upsold_orders'];
            $salesmanData[$userId]['product_upsold'] += $item['product_upsold'];
            $salesmanData[$userId]['shipping_upsold'] += $item['shipping_upsold'];
            $salesmanData[$userId]['tax_upsold'] += $item['tax_upsold'];
            $salesmanData[$userId]['total_upsold'] += $item['total_upsold'];
            $salesmanData[$userId]['total_commission'] += $item['total_commission'];
            $percentage = round($salesmanData[$userId]['total_order'] > 0 ? ($salesmanData[$userId]['order_with_upsold'] / $salesmanData[$userId]['total_order']) * 100 : 0, 2);
            $salesmanData[$userId]['upsold_orders'] = "{$salesmanData[$userId]['order_with_upsold']}/{$salesmanData[$userId]['total_order']} ($percentage%)";

            if ($salesmanData[$userId]['order_with_upsold'] != 0) {
                $salesmanData[$userId]['avg_upsold'] = round($salesmanData[$userId]['total_upsold'] / $salesmanData[$userId]['total_order'], 2);
                $salesmanData[$userId]['avg_commission'] = round($salesmanData[$userId]['total_commission'] / $salesmanData[$userId]['total_order'], 2);
            } else {
                $salesmanData[$userId]['avg_upsold'] = 0;
                $salesmanData[$userId]['avg_commission'] = 0;
            }
            $salesmanData[$userId]['username'] = $item['username'];
        }
        return $salesmanData;
    }
    public function getTotalColumnData()
    {
        $salesmanColumns = $this->getSalesmanData();
        $salesmanData['total_column'] = [
            'total_order' => 0,
            'order_with_upsold' => 0,
            'product_upsold' => 0,
            'shipping_upsold' => 0,
            'tax_upsold' => 0,
            'total_upsold' => 0,
            'avg_upsold' => 0,
            'total_commission' => 0,
            'avg_commission' => 0,
            'upsold_orders' => '0',
        ];
        foreach ($salesmanColumns as $salesman) {
            $salesmanData['total_column']['total_order'] += $salesman['total_order'];
            $salesmanData['total_column']['order_with_upsold'] += $salesman['order_with_upsold'];
            $salesmanData['total_column']['product_upsold'] += $salesman['product_upsold'];
            $salesmanData['total_column']['shipping_upsold'] += $salesman['shipping_upsold'];
            $salesmanData['total_column']['tax_upsold'] += $salesman['tax_upsold'];
            $salesmanData['total_column']['total_upsold'] += $salesman['total_upsold'];
            $salesmanData['total_column']['avg_upsold'] += $salesman['avg_upsold'];
            $salesmanData['total_column']['total_commission'] += $salesman['total_commission'];
            $salesmanData['total_column']['avg_commission'] += $salesman['avg_commission'];
            $percentage = round($salesmanData['total_column']['total_order'] > 0 ? ($salesmanData['total_column']['order_with_upsold'] / $salesmanData['total_column']['total_order']) * 100 : 0, 2);
            $salesmanData['total_column']['upsold_orders'] = "{$salesmanData['total_column']['order_with_upsold']}/{$salesmanData['total_column']['total_order']} ($percentage%)";
        }
        return $salesmanData;
    }

    public function getTodayRank($id)
    {
        $salesmanData = $this->getSalesmanData();
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
            ];
            $today_rank++;
        }
        // usort($salesmanData, function($a, $b) {
        //     if ($a['total_commission'] == $b['total_commission']) {
        //         return 0;
        //     }
        //     return ($a['total_commission'] > $b['total_commission']) ? -1 : 1;
        // });
        // foreach($salesmanData as $salesman){
        //     $rank[] = [
        //         'user_id' => $salesman['user_id'],
        //         'rank' => $today_rank,
        //     ];
        //     $today_rank++;
        // }
        foreach ($rank as $key => $value) {
            if ($value['user_id'] == $id) {
                return $value['rank'];
            }
        }
    }
    public function calculatetodayrank($id)
    {
        $rank = $this->getTodayRank($id);
        $data = [
            'user_id' => $id,
            'rank' => $rank,
        ];
        $rankModel = Mage::getModel('salesman/rank');
        $rankModel->setData($data);
    }
}
?>