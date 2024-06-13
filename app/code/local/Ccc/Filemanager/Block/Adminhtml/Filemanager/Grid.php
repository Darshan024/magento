<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setUseAjax(true);
        $this->setId('filemanager');
    }
    protected function _prepareCollection()
    {
        // echo '<pre>';
        
        $collection = Mage::getResourceModel('filemanager/filemanager_collection');
        
        // print_r(get_class_methods($collection));
        $filter = $this->getParam($this->getVarNameFilter(), null);
        $data = $this->helper('adminhtml')->prepareFilterString($filter);

        $path = isset($data['pathSelect']) ? $data['pathSelect'] : null;
        
        if($path == "default" || $path==null ) {
            $collection->addTargetDir(Mage::getBaseDir('media').DS.'banner');
            $collection->addFieldToFilter('file_id', 0);
        } else {
            $pathParts = explode('/', $path);
            $baseDir = array_shift($pathParts);
            $relativePath = implode(DS, $pathParts);
            $fullpath = Mage::getBaseDir($baseDir) . DS . $relativePath;
            $collection->addTargetDir($fullpath);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'date',
            array(
                'header' => Mage::helper('filemanager')->__('Creation Date'),
                'align' => 'left',
                'index' => 'date',
                'type' => 'datetime',
                'filter_condition_callback'=>array($this,'_fileterByDate')
            )
        );
        $this->addColumn(
            'filepath',
            array(
                'header' => Mage::helper('filemanager')->__('File Path'),
                'align' => 'left',
                'index' => 'filepath',
                'filter_condition_callback' => array($this, '_filterFilemanager')
            )
        );
        $this->addColumn(
            'basename',
            array(
                'header' => Mage::helper('filemanager')->__('File Name'),
                'align' => 'left',
                'index' => 'basename',
                'renderer'=>'Ccc_Filemanager_Block_Adminhtml_Filemanager_Grid_Renderer_Edit',
                'filter_condition_callback' => array($this, '_filterFilemanager')
            )
        );
        $this->addColumn(
            'extension',
            array(
                'header' => Mage::helper('filemanager')->__('File Extension'),
                'align' => 'left',
                'index' => 'extension',
                'filter_condition_callback' => array($this, '_filterFilemanager')
            )
        );
        $this->addColumn('actions', array(
            'header' => Mage::helper('filemanager')->__('Actions'),
            'width' => '200px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'Ccc_Filemanager_Block_Adminhtml_Filemanager_Grid_Renderer_Action'
        )
        );
        return parent::_prepareColumns();
    }
    protected function _filterFilemanager($collection, $column)
    {
        $field = $column->getIndex();
        $value = $column->getFilter()->getValue();

        if($value){
            $collection->addFieldToFilter($field, array('like' => '%' . $value . '%'));
        }
    }
    protected function _fileterByDate($collection,$column){
        $value = $column->getFilter()->getValue();
        if($value['orig_from']){
            $fromDate=date('Y-m-d H:i:s',strtotime($value['orig_from']));
            $collection->addFieldToFilter($column->getIndex(), array('gteq' =>$fromDate));
        }
        if($value['orig_to']){
            $toDate=date('Y-m-d H:i:s',strtotime($value['orig_to']));
            $collection->addFieldToFilter($column->getIndex(), array('lteq' => $toDate));
        }
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

}
?>