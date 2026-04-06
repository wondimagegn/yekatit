<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */    
     $xls->setHeader('Master Sheet');
     $xls->addXmlHeader();
     $xls->setWorkSheetName('Section'.$section_detail['name']);
     $xls->openRow();
                $xls->writeString('College:');
     $xls->closeRow(); 
      
	$xls->openRow();
	$xls->closeRow(); 
		
    $xls->addXmlFooter();
    exit();
?>

