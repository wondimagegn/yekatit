<?php  
/* 
** File: barcode.thtml 
** Location: views/test_pdfb 
*/ 
    $pdf->set('P', 'mm', array( 75.0, 33.0 )); 
    $pdf->SetMargins(0.0, 0.0); 
    $pdf->SetFont("Helvetica", "", 9.5); 

    $pdf->AddPage(); 

    //$doc_id = '1234567'; // come from controller 
    $pdf->BarCode($doc_id, "C39", 0, 4, 75.0, 33.0, 1, 1, 1, 1, "", "PNG"); 

    $pdf->SetXY(2, 4); 
    $pdf->Cell(0, 0, "Code: 39 - 17 march 2007", 0, 0, 'C'); 

    $pdf->Rect(0.3, 0.3, 74.4, 32.4); 

    $pdf->SetDisplayMode('real'); 
    $pdf->Output(); 
    $pdf->closeParsers(); 
?>
