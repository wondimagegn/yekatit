<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */
    
     $xls->setHeader('Student Id of '.$selected_college_name);
     $xls->addXmlHeader();
     $xls->setWorkSheetName('Student Id of '.$selected_college_name);
     
     if(!empty($acceptedStudents)){
	    $xls->openRow();
                $xls->writeString('College: '.$selected_college_name);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Program: '.$selected_program_name);
        $xls->closeRow();  
        $xls->openRow();
                $xls->writeString('Program Type: '.$selected_program_type_name);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Academic Year: '.$selected_acdemicyear);
        $xls->closeRow(); 
		$xls->openRow();
		$xls->closeRow(); 	
		
		$xls->openRow();
			 $xls->writeString('No');
			 $xls->writeString('Full Name');
			 $xls->writeString('Sex');
			 $xls->writeString('Student Id');
			 $xls->writeString('Region');
		$xls->closeRow();
		$count=1;
		foreach ($acceptedStudents as $acceptedStudent) { 
			$xls->openRow();
				 $xls->writeString($count++);
				 $xls->writeString($acceptedStudent['AcceptedStudent']['full_name']);
				 $xls->writeString($acceptedStudent['AcceptedStudent']['sex']);
				 $xls->writeString($acceptedStudent['AcceptedStudent']['studentnumber']);
				 $xls->writeString($acceptedStudent['Region']['name']);
			$xls->closeRow();
		}
		$xls->openRow();
		$xls->closeRow(); 	
	}
    $xls->addXmlFooter();
    exit();
?>
