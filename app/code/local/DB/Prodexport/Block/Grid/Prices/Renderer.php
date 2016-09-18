<?php
class DB_Prodexport_Block_Grid_Prices_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)  {

        $groupPrices = Mage::helper('db_prodexport')->getGroupPrices();
        $mapped = Mage::helper('db_prodexport')->getWebsitesMapping();
        $groupId = str_replace("group_price_", "", $this->getColumn()->getHeader());


        $websiteId = $mapped[(int)Mage::app()->getRequest()->getParam('store')];

        if(isset($groupPrices[$row['entity_id']])) {
            $price=$groupPrices[$row['entity_id']][$websiteId][$groupId];
            if(!$price) {
                $price=$groupPrices[$row['entity_id']][0][$groupId];
            }
            return $price;
        }
        return '';
    }
}