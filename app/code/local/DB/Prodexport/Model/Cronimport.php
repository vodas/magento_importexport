<?php

class DB_Prodexport_Model_Cronimport
{
    public function cronFunc() {

        $profileId=8;
        //$profileId=Mage::getStoreConfig('db_prodexport/dbteam_group/dataflow_profile_id');
        Mage::log('import cron, profile id:'.$profileId);

        umask(0);
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $profile = Mage::getModel('dataflow/profile');
        $profile->load($profileId);
        Mage::register('current_convert_profile', $profile);
        $profile->run();
        $batchModel = Mage::getSingleton('dataflow/batch');
        $batchImportModel = $batchModel->getBatchImportModel();
        $adapter = $batchModel->getAdapter();
        $importIds = $batchImportModel->getIdCollection();

        foreach ($importIds as $importId) {
            $batchImportModel->load($importId);
            try {
                $importData = $batchImportModel->getBatchData();
                Mage::getModel($adapter)->saveRow($importData);
            } catch (Exception $e) {
                Mage::log("Exception : " . $e);
                continue;
            }
        }

        if (method_exists($adapter, 'getEventPrefix')) {

            // Event to process rules relationships after import
            Mage::dispatchEvent($adapter->getEventPrefix() . '_finish_before', array(
                'adapter' => $adapter
            ));

            // Clear affected ids for possible reuse
            $adapter->clearAffectedEntityIds();

        }

    }

}