<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */
     //Find section name
    foreach ($students_per_section as $students):
        $section_name=$students['Section']['name'];
    endforeach;
	//input the export file name
    
	$xls->setHeader('Section_'.$section_name);

    $xls->addXmlHeader();
    $xls->setWorkSheetName('Section_'.$section_name);

    //Headings 
    $xls->openRow();
        $xls->writeString("College: ".$college_name);
    $xls->closeRow();
	$xls->openRow();
        $xls->writeString("Department: ".$department_name);
    $xls->closeRow();
	$xls->openRow();
        $xls->writeString("Section: ".$section_name);
    $xls->closeRow();
	$xls->openRow();
    $xls->closeRow();
    //2nd row for columns name
    $xls->openRow();
    $xls->writeString('No');
    $xls->writeString('ID');
    $xls->writeString('Name');
    $xls->closeRow();

    //rows for data
    foreach ($students_per_section as $students):
        for($i=0;$i<$student_count;$i++){
            $xls->openRow();
            $xls->writeString($i+1);
            $xls->writeString($students['Student'][$i]['studentnumber']);
            $xls->writeString($students['Student'][$i]['full_name']);
            $xls->closeRow();
        }
    endforeach;

    $xls->addXmlFooter();
    exit();
?>
