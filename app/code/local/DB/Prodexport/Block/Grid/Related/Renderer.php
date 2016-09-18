<?php
class DB_Prodexport_Block_Grid_Related_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public $relatedProdsMapping=null;

    public function getRelatedMapping() {
        if(is_array($this->relatedProdsMapping)) {
            return $this->relatedProdsMapping;
        }
        $mapping=array();
        $skuMapping=array();

        $sql = "SELECT entity_id, sku from catalog_product_entity";
        $rows=Mage::getSingleton('core/resource')->getConnection('core_read')->query($sql)->fetchAll();
        foreach($rows as $row) {
            $skuMapping[$row['entity_id']]=$row['sku'];
        }


        $collection = Mage::getModel('catalog/product_link')
            ->getCollection()
            ->addFieldToFilter('link_type_id','4');

        foreach($collection as $relation) {
            $mapping[$relation['product_id']][]=$skuMapping[$relation['linked_product_id']];
//            $mapping[$relation['product_id']][]=$relation['linked_product_id'];

        }

       $this->relatedProdsMapping=$mapping;
        return $this->relatedProdsMapping;

    }



    public function render(Varien_Object $row)  {

        $relatedMapping=$this->getRelatedMapping();
        if(isset($relatedMapping[$row['entity_id']])) {
            $ids=implode(',',$relatedMapping[$row['entity_id']]);
            return $ids;
        }
        return '';
    }

}