<?php
class DB_Prodexport_Model_Import extends Mage_Dataflow_Model_Convert_Adapter_Abstract
{
    protected $_storeModel;
    public $imageMapping;
    public $skuMapping;
    public $storesMapping;

    public function load()
    {
//  you have to create this method, enforced by  Mage_Dataflow_Model_Convert_Adapter_Interface
    }

    public function save()
    {
//  you have to create this method, enforced by  Mage_Dataflow_Model_Convert_Adapter_Interface
    }


    public function saveRow(array $importData)
    {

        if(!isset($importData['order_number'])) {
            return false;
        }

        $categoryMapping=Mage::helper('db_prodexport')->categoriesMapping;
        $mapped=$this->getStoresMapping();

        //$start=microtime();

        if($importData['id']=='') {  //new product
            $product=Mage::getModel('catalog/product');
            $product
                ->setAttributeSetId(4) //ID of a attribute set named 'default'
                ->setTaxClassId(2)
                ->setTypeId('simple');

            $websites=array();
            foreach (Mage::app()->getWebsites() as $website) {
                $websites[]=$website->getId();
            }
            $product->setWebsiteIds($websites);

            $product->setStockData(array(
                    'use_config_manage_stock' => 1, //'Use config settings' checkbox
                    'manage_stock'=>0, //manage stock
                    'min_sale_qty'=>0, //Minimum Qty Allowed in Shopping Cart
                    'max_sale_qty'=>0, //Maximum Qty Allowed in Shopping Cart
                    'is_in_stock' => 1  //Stock Availability
                )
            );
        }

        else {
            $product=Mage::getModel('catalog/product')->load($importData['id']);
        }


        if($importData['related']) {  //related products
            $relatedSkus=explode(',',$importData['related']);
            $relData=array();
            $skuMapping=$this->getSkuMapping();

            $i=1;
            foreach($relatedSkus as $relatedSku) {
                $relData[$skuMapping[$relatedSku]]=array('position'=>$i);
                $i++;
            }
            $product->setUpSellLinkData($relData);
        }

        $group_keys = array('group_price_6','group_price_7','group_price_8','group_price_9');
        $groupPricing = array();
        
        $groupPrices = Mage::helper('db_prodexport')->getGroupPrices();
        $groupPrice=$groupPrices[$importData['id']];

        foreach ($groupPrice as $keyGroupPrice => $prices) {
            foreach($prices as $keyPrice => $price) {
                if($keyGroupPrice!=$mapped[$importData['language_id']]) {
                    array_push($groupPricing, array('website_id' => $keyGroupPrice, 'cust_group' => $keyPrice, 'price' => $price));
                }
            }
        }

        foreach ($group_keys as $group_key) {
            array_push($groupPricing, array('website_id' => $mapped[$importData['language_id']], 'cust_group' => str_replace("group_price_", "", $group_key), 'price' => $importData[$group_key]));
        }
        $product->setData('group_price', $groupPricing);


        $product->setData('name',$importData['headline']);
        $product->setData('sku',$importData['order_number']);

        $product->setData('price',$importData['internet_price']);
//        $product->setData('meta_keyword',utf8_encode($importData['keywords']));

        if(isset($categoryMapping[$importData['category1']])) {
            $importData['category1']=$categoryMapping[$importData['category1']];
        }

        if( in_array($importData['category1'], array(9, 87, 93, 247, 246, 248, 249, 499, 501, 503, 504, 510, 522, 533, 537, 538, 539, 546, 541, 546, 547, 548, 581, 607, 499))) {
            $product->setData('is_sparepart',1);
        }
        else {
            $product->setData('is_sparepart',0);
        }

        $product->setData('category_ids',($importData['category1']+1000));

        if($importData['special_price']==0) {
            unset($importData['special_price']);
        }

        if($importData['language_id']!=0) {
            $product->setStoreId($importData['language_id']);
        }

        foreach($importData as $key=>$value) {
            $product->setData($key,$value);
        }

        $product->save();

        return true;
    }


    protected function _save_image($img) {
        $img=trim($img);
        $filepath           = Mage::getBaseDir('media') . DS . 'import'. DS . $img; //path for temp storage folder: ./media/import/
        return $filepath;
//
    }


    public function getSkuMapping() {
        if($this->skuMapping) {
            return $this->skuMapping;
        }
        $sql = "SELECT entity_id, sku from catalog_product_entity";
        $rows=Mage::getSingleton('core/resource')->getConnection('core_read')->query($sql)->fetchAll();
        foreach($rows as $row) {
            $skuMapping[$row['sku']]=$row['entity_id'];
        }
        $this->skuMapping=$skuMapping;
        return $this->skuMapping;

    }


    public function getStoresMapping() {
        if($this->storesMapping) {
            return $this->storesMapping;
        }

        $finalMapping=array();



        foreach (Mage::app()->getWebsites() as $website) {
            foreach ($website->getGroups() as $group) {
                $stores = $group->getStores();
                foreach ($stores as $store) {
                    $finalMapping[$store->getId()]=$website->getId();
                }
            }
        }
        $this->storesMapping=$finalMapping;
        return $this->storesMapping;
    }
}