<?php

class DB_Prodexport_Block_Export_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('exportprods_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()

    {
        $storeId=(int)Mage::app()->getRequest()->getParam('store');
//
        Mage::app()->setCurrentStore($storeId);

        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('special_price')
//            ->addAttributeToSelect('image')
//            ->addAttributeToSelect('short_description')
//            ->addAttributeToSelect('description')
//            ->addAttributeToSelect('meta_keyword')
//            ->addAttributeToSelect('meta_title')
            ->addAttributeToSelect('weight')
            ->addAttributeToSelect('meta_description')
            ->addAttributeToSelect('short_info1')
            ->addAttributeToSelect('short_info2')
            ->addAttributeToSelect('short_info3')
            ->addAttributeToSelect('short_info4')
            ->addAttributeToSelect('short_info5')
            ->addAttributeToSelect('short_info6')
            ->addAttributeToSelect('short_info7')
            ->addAttributeToSelect('short_info8')
            ->addAttributeToSelect('short_info9')
            ->addAttributeToSelect('short_info10')
            ->addAttributeToSelect('short_info11')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('location')
            ->addAttributeToSelect('delivery_time')
            ->addAttributeToSelect('long_delivery_time')
            ->addAttributeToSelect('cost_price')
//            ->addCategoryIds()
            ->addStoreFilter($storeId)
        ;

        $collection->joinTable(
            'catalog/category_product',
            'product_id=entity_id',
            array('single_category_id' => 'category_id'),
            null,
            'left'
        );
        

//        $collection->joinAttribute(
//            'status',
//            'catalog_product/status',
//            'entity_id',
//            null,
//            'inner',
//            $storeId
//        );


        $this->setCollection($collection);
        parent::_prepareCollection();

//        foreach ($collection as $prod) {
//            $cats=implode(',',$prod->getCategoryIds());
//            $prod->setData('cat_ids',$cats);
//        }

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('dbsearch');
        $currency = (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE);

        $this->addColumn('id', array(
            'header' => $helper->__('id'),
            'index'  => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header' => $helper->__('headline'),
            'index'  => 'name'
        ));

        $this->addColumn('language_id', array(
            'header' => $helper->__('language_id'),
            'renderer'  => 'DB_Prodexport_Block_Grid_Store_Renderer'
        ));

        $this->addColumn('meta_description', array(
            'header' => $helper->__('meta_description'),
            'index'  => 'meta_description'
        ));


//        $this->addColumn('meta_title', array(
//            'header' => $helper->__('meta_title'),
//            'index'  => 'meta_title'
//        ));
//
//
//        $this->addColumn('meta_keyword', array(
//            'header' => $helper->__('meta_keyword'),
//            'index'  => 'meta_keyword'
//        ));

        $this->addColumn('category', array(
            'header' => $helper->__('category1'),
            'index'  => 'single_category_id'
        ));

        $this->addColumn('order_number', array(
            'header' => $helper->__('order_number'),
            'index'  => 'sku'
        ));

        $this->addColumn('short_info1', array(
            'header' => $helper->__('short_info1'),
            'index'  => 'short_info1'
        ));

        $this->addColumn('short_info2', array(
            'header' => $helper->__('short_info2'),
            'index'  => 'short_info2'
        ));

        $this->addColumn('short_info3', array(
            'header' => $helper->__('short_info3'),
            'index'  => 'short_info3'
        ));

        $this->addColumn('short_info4', array(
            'header' => $helper->__('short_info4'),
            'index'  => 'short_info4'
        ));

        $this->addColumn('short_info5', array(
            'header' => $helper->__('short_info5'),
            'index'  => 'short_info5'
        ));

        $this->addColumn('short_info6', array(
            'header' => $helper->__('short_info6'),
            'index'  => 'short_info6'
        ));

        $this->addColumn('short_info7', array(
            'header' => $helper->__('short_info7'),
            'index'  => 'short_info7'
        ));

        $this->addColumn('short_info8', array(
            'header' => $helper->__('short_info8'),
            'index'  => 'short_info8'
        ));

        $this->addColumn('short_info9', array(
            'header' => $helper->__('short_info9'),
            'index'  => 'short_info9'
        ));

        $this->addColumn('short_info10', array(
            'header' => $helper->__('short_info10'),
            'index'  => 'short_info10'
        ));

        $this->addColumn('short_info11', array(
            'header' => $helper->__('short_info11'),
            'index'  => 'short_info11'
        ));

        $this->addColumn('location', array(
            'header' => $helper->__('location'),
            'index'  => 'location'
        ));


        $this->addColumn('cost_price', array(
            'header' => $helper->__('cost_price'),
            'index'  => 'cost_price'
        ));


        $this->addColumn('delivery_time', array(
            'header' => $helper->__('delivery_time'),
            'index'  => 'delivery_time'
        ));


        $this->addColumn('long_delivery_time', array(
            'header' => $helper->__('long_delivery_time'),
            'index'  => 'long_delivery_time'
        ));


        $this->addColumn('weight', array(
            'header' => $helper->__('weight'),
            'index'  => 'weight'
        ));

        $this->addColumn('status',
            array(
                'header'=> Mage::helper('catalog')->__('status'),
                'index' => 'status',
            ));


//        $this->addColumn('description', array(
//            'header' => $helper->__('long_description'),
//            'index'  => 'description'
//        ));
//
//
//        $this->addColumn('short_description', array(
//            'header' => $helper->__('short_Description'),
//            'index'  => 'short_description'
//        ));



        $this->addColumn('internet_price', array(
            'header' => $helper->__('internet_price'),
            'index'  => 'price',
            'type'   => 'currency'
        ));

        $this->addColumn('special_price', array(
            'header' => $helper->__('special_price'),
            'index'  => 'special_price',
            'type'   => 'currency'
        ));


        $this->addColumn('related', array(
            'header' => $helper->__('related'),
            'renderer'  => 'DB_Prodexport_Block_Grid_Related_Renderer'
        ));


//        $this->addColumn('image', array(
//            'header' => $helper->__('image'),
//            'index'  => 'image'
//        ));

        $this->addColumn('group_price_6', array(
            'header' => $helper->__('group_price_6'),
            'renderer'  => 'DB_Prodexport_Block_Grid_Prices_Renderer'
        ));

        $this->addColumn('group_price_7', array(
            'header' => $helper->__('group_price_7'),
            'renderer'  => 'DB_Prodexport_Block_Grid_Prices_Renderer'
        ));

        $this->addColumn('group_price_8', array(
            'header' => $helper->__('group_price_8'),
            'renderer'  => 'DB_Prodexport_Block_Grid_Prices_Renderer'
        ));

        $this->addColumn('group_price_9', array(
            'header' => $helper->__('group_price_9'),
            'renderer'  => 'DB_Prodexport_Block_Grid_Prices_Renderer'
        ));




        $this->addExportType('*/*/exportCsv', $helper->__('CSV'));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * Retrieve a file container array by grid data as CSV
     *
     * Return array with keys type and value
     *
     * @return array
     */
    public function getCsvFile()
    {
        Mage::log('getcsvfile');
        $this->_isExport = true;
        $this->_prepareGrid();

        $io = new Varien_Io_File();

        $path = Mage::getBaseDir('var') . DS . 'export' . DS;
        $name = md5(microtime());
        $file = $path . DS . $name . '.csv';

        $io->setAllowCreateFolders(true);
        $io->open(array('path' => $path));
        $io->streamOpen($file, 'w+');
        $io->streamLock(true);
        $io->streamWriteCsv($this->_getExportHeaders());

        $this->_exportIterateCollection('_exportCsvItem', array($io));

        if ($this->getCountTotals()) {
            $io->streamWriteCsv(
                Mage::helper("core")->getEscapedCSVData($this->_getExportTotals())
            );
        }

        $io->streamUnlock();
        $io->streamClose();

        return array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => true // can delete file after use
        );
    }


}