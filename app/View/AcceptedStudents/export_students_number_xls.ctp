<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */

     $this->Xls->setHeader('Student Id of '.$selected_college_name);
     $this->Xls->addXmlHeader();
     $this->Xls->setWorkSheetName('Student Id of '.$selected_college_name);

     if(!empty($acceptedStudents)){
	    $this->Xls->openRow();
                $this->Xls->writeString('Department: '.$selected_college_name);
        $this->Xls->closeRow();
		$this->Xls->openRow();
                $this->Xls->writeString('Field of study: '.$selected_department_name);
        $this->Xls->closeRow();
        $this->Xls->openRow();
                $this->Xls->writeString('Program: '.$selected_program_name);
        $this->Xls->closeRow();
        $this->Xls->openRow();
                $this->Xls->writeString('Program Type: '.$selected_program_type_name);
        $this->Xls->closeRow();
        $this->Xls->openRow();
                $this->Xls->writeString('Academic Year: '.$selected_acdemicyear);
        $this->Xls->closeRow();
		$this->Xls->openRow();
		$this->Xls->closeRow();

		$this->Xls->openRow();
			 $this->Xls->writeString('No');
			 $this->Xls->writeString('Full Name');
			 $this->Xls->writeString('Sex');
			 $this->Xls->writeString('Student Id');
			 $this->Xls->writeString('University Attended');
		$this->Xls->closeRow();
		$count=1;
		foreach ($acceptedStudents as $acceptedStudent) {
			$this->Xls->openRow();
				 $this->Xls->writeString($count++);
				 $this->Xls->writeString($acceptedStudent['AcceptedStudent']['full_name']);
				 $this->Xls->writeString($acceptedStudent['AcceptedStudent']['sex']);
				 $this->Xls->writeString($acceptedStudent['AcceptedStudent']['studentnumber']);
				 $this->Xls->writeString($acceptedStudent['AcceptedStudent']['university_attended']);
			$this->Xls->closeRow();
		}
		$this->Xls->openRow();
		$this->Xls->closeRow();
	}
    $this->Xls->addXmlFooter();
    exit();