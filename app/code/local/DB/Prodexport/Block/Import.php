<?php

class DB_Prodexport_Block_Import extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_formScripts[] = " function saveAndContinueEdit(){
            editForm.submit($('edit_form').action+'back/import/');
        }";
        
        $this->_blockGroup = 'db_prodexport';
        $this->_controller = 'import';
        $this->_headerText = Mage::helper('db_prodexport')->__('Import products');
        //'onclick' => "setLocation('{$this->getUrl($url)}')"
        parent::__construct();
        $this->_removeButton('reset');
        $this->_removeButton('back');

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and go to run'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ));




    }
}