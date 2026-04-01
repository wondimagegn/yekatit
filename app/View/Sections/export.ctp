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
    
	$this->Xls->setHeader('Section_'.$section_name);

    $this->Xls->addXmlHeader();
    $this->Xls->setWorkSheetName('Section_'.$section_name);

    //Headings 
    $this->Xls->openRow();
        $this->Xls->writeString("College: ".$college_name);
    $this->Xls->closeRow();
	$this->Xls->openRow();
        $this->Xls->writeString("Department: ".$department_name);
    $this->Xls->closeRow();
	$this->Xls->openRow();
        $this->Xls->writeString("Section: ".$section_name);
    $this->Xls->closeRow();
	$this->Xls->openRow();
    $this->Xls->closeRow();
    //2nd row for columns name
    $this->Xls->openRow();
    $this->Xls->writeString('No');
    $this->Xls->writeString('ID');
    $this->Xls->writeString('Name');
    $this->Xls->closeRow();

    //rows for data
    foreach ($students_per_section as $students):
        for($i=0;$i<$student_count;$i++){
            $this->Xls->openRow();
            $this->Xls->writeString($i+1);
            $this->Xls->writeString($students['Student'][$i]['studentnumber']);
            $this->Xls->writeString($students['Student'][$i]['full_name']);
            $this->Xls->closeRow();
        }
    endforeach;

    $this->Xls->addXmlFooter();
    exit();
?>
