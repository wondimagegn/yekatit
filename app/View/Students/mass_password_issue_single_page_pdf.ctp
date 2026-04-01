<?php
App::import('Vendor', 'tcpdf/tcpdf');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

//show header or footer
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
//SetMargins(Left, Top, Right)
$pdf->SetMargins(6, 6, 6);
//$pdf->SetTopMargin(10);
//Font Family, Style, Size
//$pdf->SetFont("pdfacourier", "", 11);
// $pdf->setPageOrientation('P', true, 0);

$header = '<table cellspacing="2">
    	<tr>
    		<td style="text-align:center; font-weight:bold">YEKATIT 12 HOSPITAL MEDICAL COLLEGE  </td>
    	</tr>


<tr>
    		<td style="text-align:center; font-weight:bold;text-decoration:underline;">Password Issue</td>
    	</tr>
    	</table>';

$count = 1;
$pdf->AddPage("P");
$nameLists = null;
$nameLists .= $header;
$nameLists .= '<table>';
$i = 1;
$numbercount = count($student_passwords);
$count = 0;
foreach ($student_passwords as $c_id => $student) {
	$count++;
	if ($i == 1) {
		$nameLists .= '<tr>';
		$nameLists .= '
	<td style="border:2px solid #000000;">
		<table cellpadding="2.5" cellspacing="1">
		  <tr>
				<td>Department/School:' . $student['College']['name'] . '
				</td>
		  </tr>
		  <tr>
				<td>Field of study/specialization:' . $student['Department']['name'] . '
				</td>
		  </tr>



		  <tr>
				<td>Full Name:' . $student['Student']['full_name'] . '
				</td>

			</tr>
          <tr>
				<td>Username/ID:' . $student['Student']['studentnumber'] . '
				</td>
			</tr>
		    <tr>
				<td>Password:' . $student['Student']['password_flat'] . '
				</td>
	        </tr>
		    <tr>
				<td>Portal:' . BASE_URL . '
				</td>
		   </tr>
		</table>
	</td>';
		$i++;
	} else {
		$nameLists .= '
	<td style="border:2px solid #000000;">
		<table cellpadding="2.5" cellspacing="1">
		  <tr>
				<td>Department/School/Center:' . $student['College']['name'] . '
				</td>
		  </tr>
		  <tr>
				<td>Field of study:' . $student['Department']['name'] . '
				</td>
		  </tr>

		  <tr>
				<td>Full Name:' . $student['Student']['full_name'] . '
				</td>

			</tr>
          <tr>
				<td>Username/ID:' . $student['Student']['studentnumber'] . '
				</td>
			</tr>
		    <tr>
				<td>Password:' . $student['Student']['password_flat'] . '
				</td>
	        </tr>
		    <tr>
				<td>Portal:' . BASE_URL . '
				</td>
		   </tr>
		</table>
	</td>';
		$i++;
	}
	if ($i == 3 || $numbercount == $count) {
		$nameLists .= '</tr>';
		$i = 1;
	}
}
$nameLists .= '</table>';
$pdf->writeHTML($nameLists);

// reset pointer to the last page
$pdf->lastPage();
//output the PDF to the browser

$pdf->Output('PasswordIssueMassPrint.' . date('Y') . '.pdf', 'I');

    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */
