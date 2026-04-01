<?php

App::import('Vendor','tcpdf/tcpdf');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true);  
//show header or footer
$pdf->SetPrintHeader(false); 
$pdf->SetPrintFooter(false);
$countryAmharic = Configure::read('ApplicationDeployedCountryAmharic'); 
$cityAmharic = Configure::read('ApplicationDeployedCityAmharic');
$countryEnglish = Configure::read('ApplicationDeployedCountryEnglish'); 
$cityEnglish = Configure::read('ApplicationDeployedCityEnglish');
$pobox=  Configure::read('POBOX');	
    // set font
    $pdf->SetMargins(3, 1, 3);
    $pdf->SetFont("freeserif", "", 11);

    $pdf->setPageOrientation('L', true, 0);
   
    $header = '<table style="width:100%;">
    	<tr>
    		<td style="text-align:center; font-weight:bold">YEKATIT 12 HOSPITAL MEDICAL COLLEGE</td>
    	</tr>
		
<tr>
    		<td style="text-align:center; font-weight:bold">OFFICE OF THE REGISTRAR</td>
    	</tr>
<tr>
    		<td style="text-align:center; font-weight:bold;text-decoration:underline;">ONLINE APPLICANT LIST</td>
    	</tr>
    	</table>';
  
   $count = 1;
   $graduationCriteria='';
   foreach($onlineapplicant_list_pdf as $c_id => $students) 
   {
	$registrationDepartmentDetail = explode('~',$c_id); 
      // add a page
     $pdf->AddPage("L");
     $graduationCriteria .= $header;
	 $graduationCriteria .= '<br/><table class="fs13 summery">
		
		

		<tr>
			<td style="width:22%">Program:</td>
			<td style="width:78%; font-weight:bold">'.$registrationDepartmentDetail[0].'</td>
		</tr>

		<tr>
			<td style="width:22%">Program Type:</td>
			<td style="width:78%; font-weight:bold">'.$registrationDepartmentDetail[1].'</td>
		</tr>
		<tr>
			<td style="width:22%">Department:</td>
			<td style="width:78%; font-weight:bold">'.$registrationDepartmentDetail[2].'</td>
		</tr>

		<tr>
			<td style="width:22%">Field of Study:</td>
			<td style="width:78%; font-weight:bold">'.$registrationDepartmentDetail[3].'</td>
		</tr>
		';

    $graduationCriteria .= '</table>';
	
	$graduationCriteria .= '<br/><table cellpadding="1" style="padding-left:2px;text-align:left;" >';
	
	/*$graduationCriteria .= '<tr><th style="width:10%;border:1px solid #000000; border-bottom:1px solid #000000;text-align:center ">S.No</th><th style="width:20%;border:1px solid #000000; border-bottom:1px solid #000000;text-align:center ">ApplicationNumber</th><th style="width:20%;border:1px solid #000000; border-bottom:1px solid #000000;text-align:center">Student Name</th><th style="width:10%;border:1px solid #000000; border-bottom:1px solid #000000;text-align:center ">Sex</th>
<th style="width:10%;border:1px solid #000000; border-bottom:1px solid #000000;">GPA/th></tr>';
*/  
  
$graduationCriteria .= '<tr><th style="width:5%;border:1px solid #000000; border-bottom:1px solid #000000;text-align:center ">S.No</th><th style="width:5%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">ApplicationNumber</th><th style="width:20%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">Student Name</th><th style="width:10%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">Sex</th><th style="width:10%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">GPA</th><th style="width:10%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">Sponsor</th>
<th style="width:10%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">Entrance Result</th>
<th style="width:10%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">Status</th>
<th style="width:20%;text-align:center;border:1px solid #000000; border-bottom:1px solid #000000; ">Remark</th>
</tr>';

    $s_count = 1;
    foreach($students as $key => $student) {
		 $graduationCriteria .='<tr><td style="border:1px solid #000000; border-bottom:1px solid #000000;text-align:center; ">'.$s_count++.'</td>
			<td style="border:1px solid #000000; border-bottom:1px solid #000000;text-align:center;">'.$student['OnlineApplicant']['applicationnumber'].'</td><td style="border:1px solid #000000; border-bottom:1px solid #000000; ">'.$student['OnlineApplicant']['full_name'].'</td>
<td style="border:1px solid #000000; border-bottom:1px solid #000000; text-align:center;">
'.(strcasecmp($student['OnlineApplicant']['gender'], 'male') == 0 ? 'M' : 'F').'</td><td style="border:1px solid #000000; border-bottom:1px solid #000000; text-align:center;">
'.$student['OnlineApplicant']['undergraduate_university_cgpa'].'</td>
<td style="border:1px solid #000000; border-bottom:1px solid #000000; text-align:center;">
'.$student['OnlineApplicant']['name_of_sponsor'].'</td> <td style="border:1px solid #000000; border-bottom:1px solid #000000; text-align:center;">
'.($student['OnlineApplicant']['entrance_result']==0 ? '':$student['OnlineApplicant']['entrance_result']).'</td> <td style="border:1px solid #000000; border-bottom:1px solid #000000; text-align:center;">
'.$student['OnlineApplicant']['status'].'</td><td style="border:1px solid #000000; border-bottom:1px solid #000000; text-align:center;">'.$student['OnlineApplicant']['status_remark'].'</td></tr>'; 
   }
   
        $graduationCriteria .='<tr><td style="width:100%">&nbsp;</td></tr>';

       $graduationCriteria .='<tr><td style="width:45%">Generated By:</td>
<td style="width:40%">Checked By:</td></tr>';

       $graduationCriteria .='<tr><td style="width:45%">SIS</td>
<td style="width:40%">Sign:______________</td><td style="width:15%">&nbsp;</td></tr>';
      $graduationCriteria .= '</table>';
      $pdf->writeHTML($graduationCriteria);	
// reset pointer to the last page
   $graduationCriteria="";
	
   }
   // reset pointer to the last page
   $pdf->lastPage();

    //output the PDF to the browser

    $pdf->Output('OnlineApplicantList.'.date('Y').'.pdf', 'I');

    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */
?>
