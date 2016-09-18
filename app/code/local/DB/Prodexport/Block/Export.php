<?php

class DB_Prodexport_Block_Export extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'db_prodexport';
        $this->_controller = 'export';
        $this->_headerText = Mage::helper('db_prodexport')->__('Export products');

        parent::__construct();
        $this->_removeButton('add');
    }
}