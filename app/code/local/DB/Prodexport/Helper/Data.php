<?php

class DB_Prodexport_Helper_Data extends Mage_Core_Helper_Abstract
{
    public $groupPrices=null;
    public $storesMapping=null;

    public $categoriesMapping=array(35=>10,34=>11,29=>13,260=>14,30=>16,31=>17,872=>18,941=>18,873=>21,928=>23,
        84=>83,266=>83, 261=>83,262=>83, 124=>83,125=>83,133=>83,134=>83,135=>83,136=>83,137=>83,138=>83,139=>83,140=>83,141=>83,142=>83, 849=>83,
        269=>90,270=>90,271=>90,272=>90, 542=>90,543=>90, 562=>90,550=>90,527=>21,
        241=>96,865=>98,243=>99, 199=>102, 244=>102,117=>115,945=>166,595=>552,862=>76,
        150=>149,151=>149,152=>149,153=>149,154=>149,155=>149,157=>149,158=>149,159=>149,160=>149,161=>149,164=>149,165=>149,
        168=>46,169=>46,170=>46,171=>46,172=>46,173=>46,174=>46,175=>46,176=>46, 188=>46,191=>46,195=>46,
        850=>215,851=>217,852=>223, 853=>224,256=>255,257=>255,258=>255,259=>255,555=>613,943=>874, 876=>875,944=>929,918=>916, 553=>494,556=>613,515=>569,508=>569,
        507=>613, 538=>537,539=>537, 546=>537, 547=>537,548=>537,549=>537,85=>255,
        499=>246, 520=>246,521=>246,522=>246,533=>246,545=>246,489=>246, 937=>246,
        248=>247,249=>247, 493=>247, 503=>247, 504=>247, 510=>247, 551=>247,916=>47,265=>264,194=>192,33=>26,544=>613,505=>613,506=>613,
        56=>149,55=>149,54=>149,53=>149,52=>149,51=>149,50=>149,49=>149,498=>566,554=>589,
    );

    public function getGroupPrices() {
        if(is_array($this->groupPrices)) {
            return $this->groupPrices;
        }

        $priceMapping=array();
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = 'SELECT * FROM catalog_product_entity_group_price';
        $rows = $connection->fetchAll($query);
        foreach($rows as $row) {

            $priceMapping[$row['entity_id']][$row['website_id']][$row['customer_group_id']]=$row['value'];
        }
        $this->groupPrices=$priceMapping;

        return $this->groupPrices;
    }

    public function getWebsitesMapping() {
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