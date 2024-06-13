<?php
class Ccc_Salesman_Model_Observer
{
    public function calculatetodayrank()
    {
        $collection = Mage::getModel('salesman/ordercommision')->getCollection();
        $columns = [
            'user_id',
            'SUM(commission) AS total_commission'
        ];
        $collection->getSelect()->group('user_id');
        $collection->addFieldToFilter('created_at', now(true));
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS)
        ->columns(
            $columns
        );
        $rankModel = Mage::getModel('salesman/rank');
        foreach($collection->getData() as $salesman){
            $data = [
                'user_id' => $salesman['user_id'],
                'rank' => $this->getTodayRank($salesman['user_id'], $collection->getData())
            ];
            $rankModel->setData($data)->save();
        }
    }
    public function getTodayRank($id,$collection)
    {
        $rank = [];
        $today_rank = 1;
        $totalCommission = [];
        foreach ($collection as $salesman) {
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
        foreach ($rank as $key => $value) {
            if ($value['user_id'] == $id) {
                return $value['rank'];
            }
        }
    }
}
?>