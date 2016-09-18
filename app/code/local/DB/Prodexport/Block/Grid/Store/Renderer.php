<?php
class DB_Prodexport_Block_Grid_Store_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

public function render(Varien_Object $row)
{
    $storeId=0;
    if(Mage::app()->getRequest()->getParam('store')) {
        $storeId=(int)Mage::app()->getRequest()->getParam('store');
    }
    return $storeId;
}

}
