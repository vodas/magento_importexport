<?php

class DB_Prodexport_ExportprodsController extends Mage_Adminhtml_Controller_Action
{
    

    public function indexAction()
    {
        $this->_title($this->__('Export products'));
        $this->loadLayout();
        $this->_setActiveMenu('datamarked/exportprods');
        $this->_addContent($this->getLayout()->createBlock('adminhtml/store_switcher'));
        $this->_addContent($this->getLayout()->createBlock('db_prodexport/export'));
        $this->renderLayout();
    }



    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('db_prodexport/export_grid')->toHtml()
        );
    }


    public function exportCsvAction()
    {
//        ini_set(max_execution_time, 300);
        $fileName = 'products.csv';
        $grid = $this->getLayout()->createBlock('db_prodexport/export_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
    

}