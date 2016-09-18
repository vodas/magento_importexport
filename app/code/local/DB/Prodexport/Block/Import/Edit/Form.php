<?php

class DB_Prodexport_Block_Import_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Choose file')));

        $fieldset->addField('fileinputname', 'file', array(
            'label'     => Mage::helper('adminhtml')->__('File label'),
            'required'  => false,
            'name'      => 'fileinputname',
        ));

        $form->setAction($this->getUrl('*/importprods/save'));
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $this->setForm($form);

        return parent::_prepareForm();

    }
}