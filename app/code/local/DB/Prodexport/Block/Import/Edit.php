<?php

class DB_Prodexport_Block_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct(); # for form containers, parent constructor should be called first

        $this->_controller = 'import';
        $this->_blockGroup = 'db_prodexport';
    }

    public function getHeaderText()
    {
        
    }


}
