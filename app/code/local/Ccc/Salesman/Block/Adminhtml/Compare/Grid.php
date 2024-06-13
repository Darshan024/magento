<?php
class Ccc_Salesman_Block_Adminhtml_Compare_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('CompareGrid');
        $this->setTemplate('salesman/compare/grid.phtml');
        $this->setUseAjax(true);
    }
    public function getChartData($data)
    {
        $formattedSalesData = [];
        if (isset($data['salesman1']) && isset($data['salesman2']) && isset($data['from_date']) && isset($data['to_date']) && isset($data['showChart'])) {
            $formattedSalesData = [['Date', "Salesman1", 'Salesman2']];
            $salesData = [];
            $salesCollection = Mage::getModel('salesman/ordercommision')->getCollection()
                ->addFieldToFilter('created_at', array('gteq' => $data['from_date']))
                ->addFieldToFilter('created_at', array('lteq' => $data['to_date']))
                ->addFieldToFilter('user_id', ['in' => [$data['salesman1'], $data['salesman2']]]);
            $columns = array(
                'user_id',
                'created_at',
                'SUM(commission) AS commission',
            );
            $salesCollection->getSelect()->reset(Zend_Db_Select::COLUMNS)
                ->columns(
                    $columns
                );
            $salesCollection->getSelect()->group('order_id');
            foreach ($salesCollection->getData() as $sale) {
                $salesData[$sale['created_at']][$sale['user_id']] = $sale['commission'];
            }
            foreach ($salesData as $date => $salesmen) {
                $row = [$date, round(floatval(isset($salesmen[$data['salesman1']]) ? $salesmen[$data['salesman1']] : 0), 2), round(floatval(isset($salesmen[$data['salesman2']]) ? $salesmen[$data['salesman2']] : 0), 2)];
                $formattedSalesData[] = $row;
            }
        }
        return $formattedSalesData;
    }
    public function getGridData($data)
    {
        $collection = Mage::getModel('salesman/ordercommision')->getCollection();
        $collection->getSelect()->group('main_table.user_id');
        $collection->getSelect()->join(
            array('u' => $collection->getTable('admin/user')),
            'main_table.user_id = u.user_id',
            array('username')
        );
        if (isset($data['salesman1']) && isset($data['salesman2']) && isset($data['from_date']) && isset($data['to_date'])) {
            $collection->addFieldToFilter('main_table.user_id', array('in' => [$data['salesman1'], $data['salesman2']]))
                ->addFieldToFilter('main_table.created_at', array('gteq' => $data['from_date']))
                ->addFieldToFilter('main_table.created_at', array('lteq' => $data['to_date']));
        }
        $productMetric = Ccc_Salesman_Model_Salesman::METRIC_PRODUCT;
        $shippingMetric = Ccc_Salesman_Model_Salesman::METRIC_SHIPPING;
        $taxMetric = Ccc_Salesman_Model_Salesman::METRIC_TAX;
        $salesmanColumns = array(
            'user_id',
            'u.username',
            'GROUP_CONCAT(distinct main_table.order_id) AS order_ids'
        );
        if (isset($data['metrics'])) {
            foreach ($data['metrics'] as $key => $value) {
                if ($value == "total_worked_orders") {
                    $salesmanColumns[] = "COUNT(distinct order_id) AS total_worked_orders";
                } elseif ($value == "total_upsell_orders") {
                    $salesmanColumns[] = "COUNT(DISTINCT CASE WHEN upsold <> 0 THEN order_id END) AS total_upsell_orders";
                } elseif ($value == "total_commission_orders") {
                    $salesmanColumns[] = "COUNT(DISTINCT CASE WHEN commission <> 0 THEN order_id END) AS total_commission_orders";
                } elseif ($value == "total_upsold") {
                    $salesmanColumns[] = "SUM(upsold) AS total_upsold";
                } elseif ($value == "total_commission") {
                    $salesmanColumns[] = "SUM(commission) AS total_commission";
                } elseif ($value == "product_upsold") {
                    $salesmanColumns[] = "SUM(CASE WHEN metric='{$productMetric}' THEN upsold ELSE 0 END) AS product_upsold";
                } elseif ($value == "shipping_upsold") {
                    $salesmanColumns[] = "SUM(CASE WHEN metric='{$shippingMetric}' THEN upsold ELSE 0 END) AS shipping_upsold";
                } elseif ($value == "tax_upsold") {
                    $salesmanColumns[] = "SUM(CASE WHEN metric='{$taxMetric}' THEN upsold ELSE 0 END) AS tax_upsold";
                } elseif ($value == "product_commission") {
                    $salesmanColumns[] = "SUM(CASE WHEN metric='{$productMetric}' THEN commission ELSE 0 END) AS product_commission";
                } elseif ($value == "shipping_commission") {
                    $salesmanColumns[] = "SUM(CASE WHEN metric='{$shippingMetric}' THEN commission ELSE 0 END) AS shipping_commission";
                } elseif ($value == "tax_commission") {
                    $salesmanColumns[] = "SUM(CASE WHEN metric='{$taxMetric}' THEN commission ELSE 0 END) AS tax_commission";
                }
            }
        }
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->columns(
                $salesmanColumns
            );
        $collection = $collection->getData();
        $salesman1Data = [];
        $salesman2Data = [];
        if (isset($data['salesman1']) && isset($data['salesman2'])) {
            foreach ($collection as $key => $value) {
                if ($collection[$key]['user_id'] == $data['salesman1']) {
                    $salesman1Data = $collection[$key];
                }
                if ($collection[$key]['user_id'] == $data['salesman2']) {
                    $salesman2Data = $collection[$key];
                }
            }
        }
        if (isset($data['metrics'])) {
            $selectedMetrics = array_values($data['metrics']);
            foreach ($selectedMetrics as $metric) {
                $differenceValue = $salesman1Data[$metric] - $salesman2Data[$metric];
                $formattedData[] = [
                    'metric' => $metric,
                    $salesman1Data['username'] => $salesman1Data[$metric],
                    $salesman2Data['username'] => $salesman2Data[$metric],
                    'difference' => round($differenceValue, 2),
                ];
            }
        }
        // print_r($formattedData);
        return $formattedData;
    }
    public function mainFunction($data)
    {
        $resultArray = [];
        $tableData = $this->getGridData($data);
        $resultArray[] = [
            'tableData' => $tableData
        ];
        if (isset($data['showChart'])) {
            $chartData = $this->getChartData($data);
            $resultArray[] = [
                'chartData' => $chartData
            ];
        }
        return json_encode($resultArray);
    }
    public function getPopupData($data)
    {
        $collection = Mage::getModel('salesman/ordercommision')->getCollection();
        $collection->getSelect()->group('main_table.order_id');
        $collection->getSelect()->join(
            array('u' => $collection->getTable('admin/user')),
            'main_table.user_id = u.user_id',
            array('username')
        );
        $collection->addFieldToFilter('u.username', $data['name'])
            ->addFieldToFilter('created_at', array('gteq' => $data['from_date']))
            ->addFieldToFilter('created_at', array('lteq' => $data['to_date']));
        $productMetric = Ccc_Salesman_Model_Salesman::METRIC_PRODUCT;
        $shippingMetric = Ccc_Salesman_Model_Salesman::METRIC_SHIPPING;
        $taxMetric = Ccc_Salesman_Model_Salesman::METRIC_TAX;
        $columns = ['main_table.order_id'];
        if ($data['metric'] == "total_worked_orders") {
            $columns[] = "COUNT(distinct order_id) AS total_worked_orders";
        } elseif ($data['metric'] == "total_upsell_orders") {
            $columns[] = "COUNT(DISTINCT CASE WHEN upsold <> 0 THEN order_id END) AS total_upsell_orders";
        } elseif ($data['metric'] == "total_commission_orders") {
            $columns[] = "COUNT(DISTINCT CASE WHEN commission <> 0 THEN order_id END) AS total_commission_orders";
        } elseif ($data['metric'] == "total_upsold") {
            $columns[] = "SUM(upsold) AS total_upsold";
        } elseif ($data['metric'] == "total_commission") {
            $columns[] = "SUM(commission) AS total_commission";
        } elseif ($data['metric'] == "product_upsold") {
            $columns[] = "SUM(CASE WHEN metric='{$productMetric}' THEN upsold ELSE 0 END) AS product_upsold";
        } elseif ($data['metric'] == "shipping_upsold") {
            $columns[] = "SUM(CASE WHEN metric='{$shippingMetric}' THEN upsold ELSE 0 END) AS shipping_upsold";
        } elseif ($data['metric'] == "tax_upsold") {
            $columns[] = "SUM(CASE WHEN metric='{$taxMetric}' THEN upsold ELSE 0 END) AS tax_upsold";
        } elseif ($data['metric'] == "product_commission") {
            $columns[] = "SUM(CASE WHEN metric='{$productMetric}' THEN commission ELSE 0 END) AS product_commission";
        } elseif ($data['metric'] == "shipping_commission") {
            $columns[] = "SUM(CASE WHEN metric='{$shippingMetric}' THEN commission ELSE 0 END) AS shipping_commission";
        } elseif ($data['metric'] == "tax_commission") {
            $columns[] = "SUM(CASE WHEN metric='{$taxMetric}' THEN commission ELSE 0 END) AS tax_commission";
        };
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS)
            ->columns(
                $columns
            );
        // print_r($collection->getData());
        return json_encode($collection->getData());
    }

}
?>