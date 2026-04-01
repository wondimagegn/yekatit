<?php

App::import('Vendor','tcpdf/tcpdf');
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
    foreach($evaluationAggregateds as $evaluationAggregated){  
       $pdf->AddPage("P");  
$header = '<table style="width:100%;">
    	<tr>
    		<td style="text-align:center; font-weight:bold"> YEKATIT 12 HOSPITAL MEDICAL COLLEGE </td>
    	</tr>
      <tr>
    		<td style="text-align:center; font-weight:bold">ACADEMIC STAFF SEMESTER EVALUTION REPORT</td>
    	</tr>
</table>';
$body = '<br /><br />
<table>
  <tr>
    <td style="width:20%">Name: </td>
    <td style="width:30%">'.$evaluationAggregated['EvaluatedStaffDetail']['Title']['title'].' '.$evaluationAggregated['EvaluatedStaffDetail']['Staff']['full_name'].'</td>

    <td style="width:10%">&nbsp;</td>
    <td style="width:20%">Academic Rank: </td>
    <td style="width:20%">'.$evaluationAggregated['EvaluatedStaffDetail']['Position']['position'].'</td>

  </tr>
  <tr>
    <td style="width:20%">Department: </td>
    <td style="width:20%">'.$evaluationAggregated['EvaluatedStaffDetail']['Department']['name'].'</td>

    <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Qualification: </td>
    <td style="width:20%">'.$evaluationAggregated['EvaluatedStaffDetail']['Staff']['education'].'</td>

  </tr>
  <tr>
    <td style="width:20%">College: </td>
    <td style="width:40%">'.$evaluationAggregated['EvaluatedStaffDetail']['College']['name'].'</td>
     <td colspan="3" style="width:60%;"> &nbsp;</td>

  </tr>
    <tr>
    <td colspan="5">&nbsp;&nbsp;<br/></td>

  </tr>
   <tr>
    <td colspan="5"><br/>Administrative post or additional assignment(if any) </td>

  </tr>
 
  <tr>
    <td colspan="5"><br/>&nbsp;&nbsp;&nbsp;</td>

  </tr>
 

  <tr>
    <td style="width:20%">Semester</td>
    <td style="width:20%">'.$evaluationAggregated['EvaluatedStaffDetail']['semester'].'</td>

    <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Academic Year</td>
    <td style="width:20%">'.$evaluationAggregated['EvaluatedStaffDetail']['academic_year'].'</td>

  </tr>
  </table>
  <br/>
  <br/>
';
$body.='<table cellspacing="2" cellpadding="2">
  <tr><td style="border:1px solid #000000;">Evalutor</td><td style="border:1px solid #000000;padding:2px;">Course</td><td style="border:1px solid #000000;padding:2px;">Section</td><td style="border:1px solid #000000;padding:2px;">Evaluation(out of 5) </td></tr>
';
$studentcount=0;
$studentrateSum=0;
foreach ($evaluationAggregated['Student'] as $ckey => $cvalue) {
       $exploded=explode('~',$ckey);
       if(!is_null($cvalue['rateconverted5percent'])){
        $studentcount++;
        $studentrateSum+=$cvalue['rateconverted5percent'];
       $body.=' <tr><td style="border:1px solid #000000;padding:2px;">Student</td><td style="border:1px solid #000000;padding:2px;">'.$exploded[0].'</td><td style="border:1px solid #000000;">'.$exploded[1].'</td>
       <td style="border:1px solid #000000;padding:2px;">'. number_format($cvalue['rateconverted5percent'],2, '.', '').'</td></tr>';
      }
}

if(!empty($evaluationAggregated['Colleague']['rateconverted5percent'])){
   $body.=' <tr><td style="border:1px solid #000000;">Colleague</td><td style="border:1px solid #000000;"></td><td style="border:1px solid #000000;"></td>
       <td style="border:1px solid #000000;">'.number_format($evaluationAggregated['Colleague']['rateconverted5percent'],2,'.','').'</td></tr>';
} else {
     $body.=' <tr><td style="border:1px solid #000000;">Colleague</td><td style="border:1px solid #000000;"></td><td style="border:1px solid #000000;"></td>
       <td style="border:1px solid #000000;">---</td></tr>';
}
if($evaluationAggregated['Head'][0]['rateconverted5percent']>0){
   $body.=' <tr><td style="border:1px solid #000000;">Department Head</td><td style="border:1px solid #000000;">&nbsp;</td><td style="border:1px solid #000000;">&nbsp;</td>
       <td style="border:1px solid #000000;">'.number_format($evaluationAggregated['Head'][0]['rateconverted5percent'],2, '.', '').'</td></tr>';
} else {
    $body.=' <tr><td style="border:1px solid #000000;">Department Head</td><td style="border:1px solid #000000;">&nbsp;</td><td style="border:1px solid #000000;">&nbsp;</td>
       <td style="border:1px solid #000000;">---</td></tr>';
}
$average=0;
if($studentcount!=0){
  $average+=($evaluationAggregated['InstructorEvalutionSetting']['student_percent']/100)*($studentrateSum/$studentcount);
}

if($evaluationAggregated['Colleague']['rateconverted5percent']!=0){
  $average+=($evaluationAggregated['InstructorEvalutionSetting']['colleague_percent']/100)*($evaluationAggregated['Colleague']['rateconverted5percent']);
}
debug($average);
if($evaluationAggregated['Head'][0]['rateconverted5percent']>0){
  $average+=($evaluationAggregated['InstructorEvalutionSetting']['head_percent']/100)*($evaluationAggregated['Head'][0]['rateconverted5percent']);
}


$body.=' <tr><td colspan="3" style="border:1px solid #000000;">
Average
 </td><td style="border:1px solid #000000;">'.
 number_format($average,2, '.', '').'</td></tr>';

$body.='</table>';

$footer = '<br />
<table>
<tr>
    <td style="width:100%;">Comments of the department head</td>
  </tr>
   <tr>
    <td style="width:100%;border-bottom:1px solid #000000;">&nbsp;</td>
   
  </tr>
   <tr>
    <td style="width:100%;border-bottom:1px solid #000000;">&nbsp;</td>
   
  </tr>
  
   
  <tr>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
    <td style="width:20%;">&nbsp;</td>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
     <td style="width:20%">&nbsp;</td>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
  </tr>
 <tr>
    <td style="width:100%;">&nbsp;<br/></td>
   
  </tr>
  <tr>
    <td style="width:20%">Name</td>
    <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Signature</td>
     <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Date</td>
  </tr>
 <tr>
    <td style="width:100%;">&nbsp;<br/></td>
   
  </tr>
   <tr>
    <td style="width:100%;">Approval By Dean</td>
  </tr>
  <tr>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
    <td style="width:20%;">&nbsp;</td>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
     <td style="width:20%">&nbsp;</td>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
  </tr>
 <tr>
    <td style="width:100%;">&nbsp;<br /> <br /></td>
   
  </tr>
  <tr>
    <td style="width:20%">Name</td>
    <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Signature</td>
     <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Date</td>
  </tr>
 <tr>
    <td style="width:100%;">&nbsp;<br /> <br /></td>
   
  </tr>
  <tr>
    <td style="width:100%;">Received by archives and personnel section.</td>
  </tr>
  <tr>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
    <td style="width:20%;">&nbsp;</td>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
     <td style="width:20%">&nbsp;</td>
    <td style="width:20%;border-bottom:1px solid #000000;">&nbsp;</td>
  </tr>
<tr>
    <td style="width:100%;">&nbsp;<br /> </td>
   
  </tr>
  <tr>
    <td style="width:20%">Name</td>
    <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Signature</td>
     <td style="width:20%">&nbsp;</td>
    <td style="width:20%">Date</td>
  </tr>
</table>
';
$footer .='
<table>
<tr>
    <td style="width:100%;font-weight:bold;">This is to be filled in two copies: One copy for the department and the other copy for the archives and personnel section.</td>
  </tr>
  <tr>
    <td style="width:100%;font-weight:bold;">Average = '.($evaluationAggregated['InstructorEvalutionSetting']['student_percent']/100).' student + '.($evaluationAggregated['InstructorEvalutionSetting']['head_percent']/100).' dept head + '.($evaluationAggregated['InstructorEvalutionSetting']['colleague_percent']/100).' colleague </td>
  </tr>

</table>
';

    $content=$header.' '.$body.' '.$footer;
  
    $pdf->writeHTML($content); 
    
   }
 
    $pdf->lastPage();
    //output the PDF to the browser

    //output the PDF to the browser

    $pdf->Output('Instructor Evaluation Report.'.date('Y').'.pdf', 'I');

    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */
?>
