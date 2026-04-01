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
    foreach($student_passwords as $key => $student_copy) {
    $pdf->AddPage("P");
    $pdf->SetLineStyle(array('dash' => 0, 'width' => '1'));
    $pdf->Ln(50);
    //Image processing
    if (isset($student_copy['University'])) {
       
            if(strcasecmp($student_copy['University']['Attachment']['0']['group'], 'logo') == 0)	{
            	$logo_index = 0;
            }
            else {
            	$logo_index = 1;
            }
     
    }
    
    $logo_path = $this->Media->file($student_copy['University']['Attachment'][$logo_index]['dirname'].
    DS.$student_copy['University']['Attachment'][$logo_index]['basename']);
	
    //HEADER
    $pdf->Image($logo_path, '5', '5', 25, 25, '', '', 'N', true, 300, 'C');
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/palatino_bold.ttf');
    $pdf->SetFont($fontPath, '', 16, '', false);
    $pdf->MultiCell(92, 7, ($student_copy['University']['University']['name']), 0, 'C', false, 0, 1, 12);
    $pdf->SetFont($fontPath, '', 13, '', false);
    //$pdf->MultiCell(92, 7, $student_copy['College']['name'], 0, 'C', false, 0, 1, 18);
    //$pdf->SetFont($fontPath, 'U', 12, '', false);
    if(!empty($student_copy['Department']) && !empty($student_copy['Department']['id'])) {
		 $pdf->MultiCell(92, 7, $student_copy['Department']['name'].' Department', 0, 'C', false, 0, 1, 32);
    }
    else {
		 $pdf->MultiCell(92, 7, 'Freshman Program', 0, 'C', false, 0, 1, 22);
    }
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
    $pdf->SetFont($fontPath, '', 20, '', true);
    $pdf->MultiCell(85, 7, strtoupper($student_copy['University']['University']['amharic_name']), 0, 'C', false, 0, 120, 11);
    $pdf->SetFont($fontPath, '', 15, '', false);
    //$pdf->MultiCell(85, 7, $student_copy['College']['amharic_name'], 0, 'C', false, 0, 120, 17);
    //$pdf->SetFont($fontPath, 'U', 12, '', false);
    
    if(!empty($student_copy['Department']) && !empty($student_copy['Department']['id'])) {
		 $pdf->MultiCell(85, 7, $student_copy['Department']['amharic_name'].' ዲፓርትመንት', 0, 'C', false, 0, 120, 30);
    }
    else {
		 $pdf->MultiCell(85, 7, 'የመጀመሪያ አመት ተማሪዎች', 0, 'C', false, 0, 120, 22);
    }
	 //Department/College Address
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/bookman_old_style.ttf');
    $pdf->SetFont($fontPath, '', 12, '', false);
    $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/app/webroot/img/post_icon.png', '40', '26', 7, 7, 'PNG', '', '', true, 300, '');
    $pdf->MultiCell(15, 7, '257', 0, 'C', false, 0, 45, 27);
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
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/bookman_old_style.ttf');
    $pdf->SetFont($fontPath, '', 12, '', false);
    $pdf->Line(2, 43, 207, 43);
    $pdf->SetFont('jiret', '', 15, '', true);
    $pdf->MultiCell(157, 7, 'አዲስ አበባ', 0, 'C', false, 0, 27, 31);
    $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/bookman_old_style_b.ttf');
    $pdf->SetFont($fontPath, '', 11, '', false);
    $pdf->MultiCell(157, 7, 'Addis Ababa, Ethiopia', 0, 'C', false, 0, 27, 36);
    //Footer
 $welcomeFirstTime=null;
if(!empty($student_copy['User']['last_login'])) { 
    $welcomeFirstTime= '
        <td colspan="4"> This is a password reset letter, please login to our student information system portal 
        ('.BASE_URL.'), using the account below: </td>
    ';
} else {
  $welcomeFirstTime= '
        <td colspan="4"> Welcome to '.$student_copy['University']['University']['name'].' and its exciting world of knowledge. 
        We assure you that you will definitely benefit from your stay at '.
        $student_copy['University']['University']['name'].'. All academic 
        related transaction is handled by our student information system. Inorder to access 
        the student portal('.BASE_URL.'), use the account below: </td>';
} 


 $student_copy_html = '<table style="width:100%" border="0" cellpadding="0" cellspacing="0" >
  
    <tr>
        <td colspan="4"> Dear '.$student_copy['Student']['full_name'].', </td>
    </tr>
     <tr>
        <td colspan="4"> &nbsp;</td>
    </tr>
    <tr> 
    '.$welcomeFirstTime.'
    </tr>
	
     <tr>
        <td colspan="4"> &nbsp;</td>
    </tr>
	<tr>
		<td style="font-weight:bold">Username:</td>
		<td>'.$student_copy['Student']['studentnumber'].'</td>
		
	</tr>
	
	<tr>
		
		<td style="font-weight:bold">Password:</td>
		<td>'.$student_copy['Student']['password_flat'].'</td>
	</tr>
	 <tr>
        <td colspan="4"> &nbsp;</td>
    </tr>
	<tr>
        <td colspan="4">NOTE: In the first login you will be forced to chanage 
        your password so change the password accordingly to access the portal.
        </td>
    </tr>
     <tr>
        <td colspan="4"> &nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">Always remember your password and you are advised to keep it
         secure and secret particularly if using a shared computer.
        </td>
    </tr>
	

</table>
<br /><br />
';
	
	$fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/bookman_old_style_b.ttf');
	$pdf->SetFont($fontPath, '', 15, '', false);
   $pdf->MultiCell(157, 7, 'Student\'s Password Issue Letter', 0, 'C', false, 0, 27, 46);
	$pdf->Ln(15);
	$fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/bookman_old_style.ttf');
	$pdf->SetFont($fontPath, '', 11, '', false);
	$pdf->writeHTML($student_copy_html);
  	 // reset pointer to the last page
	}
	 $pdf->lastPage();
    //output the PDF to the browser

    $pdf->Output('password_issue.pdf', 'I');
    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */
?>
