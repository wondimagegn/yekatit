<?php
//debug($student_copies);
App::import('Vendor','tcpdf/tcpdf');
	 // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
	 
    //show header or footer
    $pdf->SetPrintHeader(false); 
    $pdf->SetPrintFooter(false);
    //SetMargins(Left, Top, Right)
    $pdf->SetMargins(10, 10, 10);
    //$pdf->SetTopMargin(10);
    //Font Family, Style, Size
    //$pdf->SetFont("pdfacourier", "", 11);
    $pdf->setPageOrientation('P', true, 0);
   	$countryAmharic = Configure::read('ApplicationDeployedCountryAmharic'); 
	$cityAmharic = Configure::read('ApplicationDeployedCityAmharic');
	
	$countryEnglish = Configure::read('ApplicationDeployedCountryEnglish'); 
	$cityEnglish = Configure::read('ApplicationDeployedCityEnglish');
	$pobox=  Configure::read('POBOX');
	 
    foreach($student_copies as $key => $student_copy) {
    $pdf->AddPage("P");
    $pdf->SetLineStyle(array('dash' => 0, 'width' => '1'));
    $pdf->Ln(50);
    //Image processing
    if(strcasecmp($student_copy['University']['Attachment']['0']['group'], 'logo') == 0)	{
    	$logo_index = 0;
    }
    else {
    	$logo_index = 1;
    }
	 $logo_path = $this->Media->file($student_copy['University']['Attachment'][$logo_index]['dirname'].DS.$student_copy['University']['Attachment'][$logo_index]['basename']);
	 //HEADER
    $pdf->Image($logo_path, '5', '5', 25, 25, '', '', 'N', true, 300, 'C');
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/palatino_bold.ttf');
    $pdf->SetFont($fontPath, '', 16, '', false);
    $pdf->MultiCell(92, 7, ($student_copy['University']['University']['name']), 0, 'C', false, 0, 1, 12);
    $pdf->SetFont($fontPath, '', 13, '', false);
    $pdf->MultiCell(92, 7, $student_copy['College']['name'], 0, 'C', false, 0, 1, 18);
    $pdf->SetFont($fontPath, 'U', 12, '', false);
    if(!empty($student_copy['Department']) && !empty($student_copy['Department']['id'])) {
		 $pdf->MultiCell(92, 7, $student_copy['Department']['name'].'', 0, 'C', false, 0, 1, 22);
    }
    else {
		 $pdf->MultiCell(92, 7, 'Freshman Program', 0, 'C', false, 0, 1, 22);
    }
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/jiret.ttf');
    $pdf->SetFont($fontPath, '', 20, '', true);
    $pdf->MultiCell(85, 7, strtoupper($student_copy['University']['University']['amharic_name']), 0, 'C', false, 0, 120, 11);
    $pdf->SetFont($fontPath, '', 15, '', false);
    $pdf->MultiCell(85, 7, $student_copy['College']['amharic_name'], 0, 'C', false, 0, 120, 17);
    $pdf->SetFont($fontPath, 'U', 12, '', false);
    if(!empty($student_copy['Department']) && !empty($student_copy['Department']['id'])) {
		 $pdf->MultiCell(85, 7, $student_copy['Department']['amharic_name'].'', 0, 'C', false, 0, 120, 22);
    }
    else {
		 $pdf->MultiCell(85, 7, 'የመጀመሪያ አመት ተማሪዎች', 0, 'C', false, 0, 120, 22);
    }
	 //Department/College Address
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/bookman_old_style.ttf');
    $pdf->SetFont($fontPath, '', 12, '', false);
    $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/app/webroot/img/post_icon.png', '40', '26', 7, 7, 'PNG', '',
     '', true, 300, '');
     
    $pdf->MultiCell(15, 7,$pobox, 0, 'C', false, 0, 42, 27);
    
    if((!empty($student_copy['Department']) && !empty($student_copy['Department']['id']) && 
    !empty($student_copy['Department']['phone'])) || 
    	(empty($student_copy['Department']) && !empty($student_copy['Department']['id']) && 
    	!empty($student_copy['College']['phone']))
    	) {
	 	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/app/webroot/img/phone_icon.png', '140', '26', 7, 7, 'PNG', '', '', true, 300, '');
    	if((!empty($student_copy['Department']) && !empty($student_copy['Department']['id']))) {
    		$pdf->MultiCell(100, 7, $student_copy['Department']['phone'], 0, 'L', false, 0, 146, 27);
    	}
		else {
			$pdf->MultiCell(100, 7, $student_copy['College']['phone'], 0, 'L', false, 0, 146, 27);
		}
	 }

    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/bookman_old_style.ttf');
    $pdf->SetFont($fontPath, '', 12, '', false);
    $pdf->Line(2, 43, 207, 43);
    $pdf->SetFont('jiret', '', 15, '', true);
    
    $pdf->MultiCell(157, 7, $cityAmharic.'፡ '.$countryAmharic, 0, 'C', false, 0, 27, 31);
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/bookman_old_style_b.ttf');
    $pdf->SetFont($fontPath, '', 11, '', false);
    $pdf->MultiCell(157, 7, ''.$cityEnglish.', '.$countryEnglish.'', 0, 'C', false, 0, 27, 36);
    //Footer
    //$pdf->Line(2, 266, 207, 266);
    $student_copy_html = '<table style="width:100%">
	<tr>
		<td style="width:3%" rowspan="5"></td>
		<td style="width:17%; font-weight:bold">Name:</td>
		<td style="width:40%">'.$student_copy['Student']['full_name'].'</td>
		<td style="width:17%; font-weight:bold">Program:</td>
		<td style="width:20%">'.$student_copy['Program']['name'].'</td>
		<td style="width:3%" rowspan="5"></td>
	</tr>
	<tr>
		<td style="font-weight:bold">ID N<u>o</u>:</td>
		<td>'.$student_copy['Student']['studentnumber'].'</td>
		<td style="font-weight:bold">Program Type:</td>
		<td>'.$student_copy['ProgramType']['name'].'</td>
	</tr>
	<tr>
		<td style="font-weight:bold">'.(strpos(strtolower($student_copy['College']['name']), 'institute') !== false ? 'Institute' : 'College').':</td>
		<td>'.$student_copy['College']['name'].'</td>
		<td style="font-weight:bold">Department:</td>
		<td>'.$student_copy['Department']['name'].'</td>
	</tr>
	<tr>
		<td style="font-weight:bold">Section:</td>
		<td>'.$student_copy['Section']['name'].'</td>
		<td style="font-weight:bold">Year Level:</td>
		<td>'.$student_copy['YearLevel']['name'].'</td>
	</tr>
	<tr>
		<td style="font-weight:bold">Academic Year:</td>
		<td>'.$student_copy['academic_year'].'</td>
		<td style="font-weight:bold">Semester:</td>
		<td>'.$student_copy['semester'].'</td>
	</tr>
</table>
<br /><br />
<table style="width:100%">
	<tr>
		<th rowspan="'.(count($student_copy['courses'])+2).'" style="width:2%"></th>
		<th style="border:1px solid #000000; border-bottom:2px solid #000000; width:5%">N<u>o</u></th>
		<th style="border:1px solid #000000; border-bottom:2px solid #000000; width:16%">Course Code</th>
		<th style="border:1px solid #000000; border-bottom:2px solid #000000; width:41%">Course Title</th>
		<th style="border:1px solid #000000; border-bottom:2px solid #000000; width:13%; text-align:center">'.(strcasecmp($student_copy['Curriculum']['type_credit'], 'Credit') == 0 ? 'Credit Hour' : 'ECTS').'</th>
		<th style="border:1px solid #000000; border-bottom:2px solid #000000; width:8%; text-align:center">Grade</th>
		<th style="border:1px solid #000000; border-bottom:2px solid #000000; width:13%; text-align:center">Grade Point</th>
		<th rowspan="'.(count($student_copy['courses'])+2).'" style="width:2%"></th>
	</tr>';
$c_count = 0;
$credit_hour_sum = 0;
$grade_point_sum = 0;
foreach($student_copy['courses'] as $key => $course_reg_add) {
$c_count++;
if(isset($course_reg_add['Grade']['grade'])) {
	if(isset($course_reg_add['Grade']['used_in_gpa']) && $course_reg_add['Grade']['used_in_gpa'] == 1) {
		$credit_hour_sum += $course_reg_add['Course']['credit'];
		$grade_point_sum += ($course_reg_add['Grade']['point_value']*$course_reg_add['Course']['credit']);
	}
	else if(strcasecmp($course_reg_add['Grade']['grade'], 'I') == 0) {
		$credit_hour_sum += $course_reg_add['Course']['credit'];
	}
}
else {
	$credit_hour_sum += $course_reg_add['Course']['credit'];
}
$student_copy_html .= '<tr>
		<td style="border:1px solid #000000">'.$c_count.'</td>
		<td style="border:1px solid #000000">'.$course_reg_add['Course']['course_code'].'</td>
		<td style="border:1px solid #000000">'.$course_reg_add['Course']['course_title'].'</td>
		<td style="border:1px solid #000000; text-align:center">'.$course_reg_add['Course']['credit'].'</td>
		<td style="border:1px solid #000000; text-align:center">'.(isset($course_reg_add['Grade']['grade']) ? $course_reg_add['Grade']['grade'] : '---').'</td>
		<td style="border:1px solid #000000; text-align:center">'.(isset($course_reg_add['Grade']['grade']) && isset($course_reg_add['Grade']['used_in_gpa']) && $course_reg_add['Grade']['used_in_gpa'] == 1 ? ($course_reg_add['Grade']['point_value']*$course_reg_add['Course']['credit']) : '---').'</td>
	</tr>';
}
$student_copy_html .= '<tr>
		<td colspan="3" style="border:1px solid #000000; text-align:right; font-weight:bold">TOTAL</td>
		<td style="border:1px solid #000000; text-align:center; border-top:2px solid #000000; font-weight:bold">'.($credit_hour_sum != 0 ? $credit_hour_sum : '---').'</td>
		<td style="border:1px solid #000000; border-top:2px solid #000000">&nbsp;</td>
		<td style="border:1px solid #000000; text-align:center; border-top:2px solid #000000; font-weight:bold">'.($grade_point_sum != 0 ? $grade_point_sum : '---').'</td>
	</tr>
</table>';


$student_copy_html .= '<br /><br /><table>
	<tr>
		<td style="width:2%"></td>
		<td style="width:34%">
			<table>
				<tr>
					<td colspan="2" style="font-weight:bold"><u>Previous</u></td>
				</tr>
				<tr>
					<td style="width:62%">'.(strcasecmp($student_copy['Curriculum']['type_credit'], 'Credit') == 0 ? 'Credit Hour' : 'ECTS').' Taken: </td>
					<td style="width:38%">'.(isset($student_copy['PreviousStudentExamStatus']['previous_credit_hour_sum']) ? $student_copy['PreviousStudentExamStatus']['previous_credit_hour_sum'] : '---').'</td>
				</tr>
				<tr>
					<td>Grade Point Earned: </td>
					<td>'.(isset($student_copy['PreviousStudentExamStatus']['previous_grade_point_sum']) ? $student_copy['PreviousStudentExamStatus']['previous_grade_point_sum'] : '---').'</td>
				</tr>
				<tr>
					<td>SGPA: </td>
					<td>'.(isset($student_copy['PreviousStudentExamStatus']['sgpa']) ? $student_copy['PreviousStudentExamStatus']['sgpa'] : '---').'</td>
				</tr>
				<tr>
					<td>CGPA:</td>
					<td>'.(isset($student_copy['PreviousStudentExamStatus']['cgpa']) ? $student_copy['PreviousStudentExamStatus']['cgpa'] : '---').'</td>
				</tr>
				<tr>
					<td>Status:</td>
					<td'.(isset($student_copy['PreviousStudentExamStatus']['academic_status_id']) ? ($student_copy['PreviousStudentExamStatus']['academic_status_id'] == 4 ? ' class="rejected"' : ($student_copy['PreviousStudentExamStatus']['academic_status_id'] == 3 ? ' class="on-process"' : ' class="accepted"')) : '').'>'.(isset($student_copy['PreviousAcademicStatus']['name']) ? $student_copy['PreviousAcademicStatus']['name'] : '---').'</td>
				</tr>
			</table>
		</td>
		<td style="width:35%">
			<table>
				<tr>
					<td colspan="2" style="font-weight:bold"><u>This Semester</u></td>
				</tr>
				<tr>
					<td style="width:60%">'.(strcasecmp($student_copy['Curriculum']['type_credit'], 'Credit') == 0 ? 'Credit Hour' : 'ECTS').' Taken: </td>
					<td style="width:40%">'.($credit_hour_sum != 0 ? $credit_hour_sum : '---').'</td>
				</tr>
				<tr>
					<td>Grade Point Earned: </td>
					<td>'.($grade_point_sum != 0 ? $grade_point_sum : '---').'</td>
				</tr>
				<tr>
					<td>SGPA: </td>
					<td>'.(isset($student_copy['StudentExamStatus']['sgpa']) ? $student_copy['StudentExamStatus']['sgpa'] : '---').'</td>
				</tr>
				<tr>
					<td>CGPA:</td>
					<td>'.(isset($student_copy['StudentExamStatus']['cgpa']) ? $student_copy['StudentExamStatus']['cgpa'] : '---').'</td>
				</tr>
				<tr>
					<td>Status:</td>
					<td'.(isset($student_copy['StudentExamStatus']['academic_status_id']) ? ($student_copy['StudentExamStatus']['academic_status_id'] == 4 ? ' class="rejected"' : ($student_copy['StudentExamStatus']['academic_status_id'] == 3 ? ' class="on-process"' : ' class="accepted"')) : '').'>'.(isset($student_copy['AcademicStatus']['name']) ? $student_copy['AcademicStatus']['name'] : '---').'</td>
				</tr>
			</table>
		</td>
		<td style="width:29%">
			<table>
				<tr>
					<td colspan="2" style="font-weight:bold"><u>Cumulative Academic Status</u></td>
				</tr>
				<tr>
					<td style="width:78%">Total '.(strcasecmp($student_copy['Curriculum']['type_credit'], 'Credit') == 0 ? 'Credit Hour' : 'ECTS').' Taken: </td>
					<td style="width:22%">';

					if($credit_hour_sum != 0 && isset($student_copy['PreviousStudentExamStatus']['previous_credit_hour_sum'])) {
						$student_copy_html .= ($student_copy['PreviousStudentExamStatus']['previous_credit_hour_sum'] + $credit_hour_sum);
					}
					else if($credit_hour_sum != 0) {
						$student_copy_html .= $credit_hour_sum;
					}
					else {
						$student_copy_html .= '---';
					}
					
$student_copy_html .= '</td>
				</tr>
				<tr>
					<td>Total Grade Point Earned: </td>
					<td>';

					if($grade_point_sum != 0 && isset($student_copy['PreviousStudentExamStatus']['previous_grade_point_sum'])) {
						$student_copy_html .= $student_copy['PreviousStudentExamStatus']['previous_grade_point_sum'] + $grade_point_sum;
					}
					else if($grade_point_sum != 0) {
						$student_copy_html .= $grade_point_sum;
					}
					else {
						$student_copy_html .= '---';
					}
					
$student_copy_html .= '</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';

$student_copy_html .= '<br /><br />
<table>
	<tr>
		<td style="width:2%"></td>
		<td style="width:48%">
			<table>
				<tr>
					<td><u>Prepared By</u></td>
				</tr>
				<tr>
					<td style="width:25%">Name:</td>
					<td style="width:75%; border-bottom:1px solid #000000"></td>
				</tr>
				<tr>
					<td>Signature:</td>
					<td style="border-bottom:1px solid #000000"></td>
				</tr>
				<tr>
					<td>Date:</td>
					<td style="border-bottom:1px solid #000000">'.date('d F, Y').'</td>
				</tr>
			</table>
		</td>
		<td style="width:2%"></td>
		<td style="width:46%">
			<table>
				<tr>
					<td><u>Approved By</u></td>
				</tr>
				<tr>
					<td style="vertical-align:bottom; width:25%">Name:</td>
					<td style="width:75%; border-bottom:1px solid #000000"></td>
				</tr>
				<tr>
					<td>Signature:</td>
					<td style="border-bottom:1px solid #000000"></td>
				</tr>
				<tr>
					<td>Date:</td>
					<td style="border-bottom:1px solid #000000"></td>
				</tr>
			</table>
		</td>
		<td style="width:2%"></td>
	</tr>
</table>
';
	
	$fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/bookman_old_style_b.ttf');
	$pdf->SetFont($fontPath, '', 15, '', false);
   $pdf->MultiCell(157, 7, 'Student\'s Examination Grade Report', 0, 'C', false, 0, 27, 46);
	$pdf->Ln(15);
	$fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/vendors/tcpdf/fonts/bookman_old_style.ttf');
	$pdf->SetFont($fontPath, '', 11, '', false);
	$pdf->writeHTML($student_copy_html);
  	 // reset pointer to the last page
	}
	 $pdf->lastPage();
    //output the PDF to the browser

    $pdf->Output('student_copy.pdf', 'I');
    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */
?>
