<?php
class DB_Prodexport_Block_Fileslisting extends Mage_Core_Block_Template
{
    public function getFileslisting() {

        $myPath='var/import/regular';
        $filenames = array_diff(scandir($myPath), array('..', '.'));

        return $filenames;
  }

    public function getLastImportedFile() {

        $myPath='var/import/regular/processed';
        $filenames = array_diff(scandir($myPath), array('..', '.'));
        arsort($filenames);
        $file = array_values($filenames)[1];

        return $file;
    }
}