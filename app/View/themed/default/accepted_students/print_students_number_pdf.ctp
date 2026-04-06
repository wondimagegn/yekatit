<?php
App::import('Vendor','tcpdf/tcpdf');
// create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 

    //show header or footer
    $pdf->SetPrintHeader(false); 
    $pdf->SetPrintFooter(false);
    //$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 
    // set default header data
   
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //set margins
    
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //$pdf->SetMargins(15,15,15);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // set font
    $pdf->SetFont("freeserif", "", 11);

    // add a page
    $pdf->AddPage();

    if(!empty($acceptedStudents)){
		$pdf->writeHTML('<div style="width:800px;text-align:left;font-size:60px;font-weight:bold">College: '.$selected_college_name.'</div>', true, 0, true, 0,'');
		$pdf->writeHTML('<div style="width:800px;text-align:left;font-size:60px;font-weight:bold">Program: '.$selected_program_name.'</div>', true, 0, true, 0,'');
		$pdf->writeHTML('<div style="width:800px;text-align:left;font-size:60px;font-weight:bold">Program Type: '.$selected_program_type_name.'</div>', true, 0, true, 0,'');
		$pdf->writeHTML('<div style="width:800px;text-align:left;font-size:60px;font-weight:bold">Academic Year: '.$selected_acdemicyear.'</div>', true, 0, true, 0,'');
			
		$tbl = '<table style="width: 800px;" cellspacing="0">';
		$tbl .= '<tr><th style="border: 1px solid #000000; width: 40px;font-size:40px;font-weight:bold;">No</th>
				<th style="border: 1px solid #000000; width: 260px;font-size:40px;font-weight:bold;">Full Name</th>
				<th style="border: 1px solid #000000; width: 50px;font-size:40px;font-weight:bold;">Sex</th>
				<th style="border: 1px solid #000000; width: 100px;font-size:40px;font-weight:bold;">Student Id</th>
				<th style="border: 1px solid #000000; width: 150px;font-size:40px;font-weight:bold;">Region</th></tr>';
				
		$count=1;
	   foreach ($acceptedStudents as $acceptedStudent) { 
			$tbl .= '
			<tr>
				<td style="border: 1px solid #000000; width: 40px;">'.$count++.'</td>
				<td style="border: 1px solid #000000; width: 260px;">'.$acceptedStudent['AcceptedStudent']['full_name'].'</td>
				<td style="border: 1px solid #000000; width: 50px;">'.$acceptedStudent['AcceptedStudent']['sex'].'</td>
				<td style="border: 1px solid #000000; width: 100px;">'. $acceptedStudent['AcceptedStudent']['studentnumber'].'</td>
				<td style="border: 1px solid #000000; width: 150px;">'. $acceptedStudent['Region']['name'].'</td>
			</tr>';
		   }
		  $tbl .= '</table>';
		  $pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
    // reset pointer to the last page
    $pdf->lastPage();

    //output the PDF to the browser

    $pdf->Output('Student Id of '.$selected_college_name.'.pdf', 'D');
    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */
?> 
