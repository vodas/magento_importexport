<?php

class DB_Prodexport_ImportprodsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
        $this->_title($this->__('Import products'));
        $this->loadLayout();
        $this->_setActiveMenu('datamarked/importprods');
        $this->_addContent($this->getLayout()->createBlock('db_prodexport/import'));
        $this->_addContent($this->getLayout()
            ->createBlock('db_prodexport/fileslisting')
            ->setTemplate('fileslisting/fileslisting.phtml'));
        $this->renderLayout();
    }

    public function saveAction() {
        if($data = $this->getRequest()->getPost()) {

            if(isset($_FILES['fileinputname']['name']) and (file_exists($_FILES['fileinputname']['tmp_name']))) {
                try {

                    $uploader = new Varien_File_Uploader('fileinputname');
                    $uploader->setAllowedExtensions(array('csv')); // or pdf or anything
                    $uploader->setAllowRenameFiles(true);
                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    //setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('var')."/import/regular". DS ;
                    $time = date('YmdHis');
                    $newName="prodimport";
                    $_FILES['fileinputname']['name']=$newName."_".$time.".csv";
                    $uploader->save($path, $_FILES['fileinputname']['name']);
                    Mage::getSingleton('core/session')->addSuccess('File uploaded');



                }catch(Exception $e) {
                    Mage::getSingleton('core/session')->addError('Error: '.$e->getMessage());
                }
            }

        }

        $params = $this->getRequest()->getParams();
        $back = $params['back'];
        if ($back != 'import') {
            $this->_redirect('*/*/index');
        } else {
            $this->_redirect('/system_convert_profile/edit/id/8/');
        }

    }


}