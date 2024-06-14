<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tab_Event extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('event');
        $this->setTemplate('outlook/grid.phtml');
    }
    public function getEventData()
    {
        $eventData = Mage::registry('outlook_event');
        return $eventData;
    }
}
?>