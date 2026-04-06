<?php
App::import('Vendor', 'tcpdf/tcpdf');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

//show header or footer
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
//SetMargins(Left, Top, Right)
$pdf->SetMargins(1, 1, 1);
$fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'] . '/app/Vendor/tcpdf/fonts/BookmanOldStyleRegular.ttf');
$pdf->SetFont($fontPath, '', 11, '', false);
$pdf->setPageOrientation('P', true, 0);
$countryAmharic = Configure::read('ApplicationDeployedCountryAmharic');
$cityAmharic = Configure::read('ApplicationDeployedCityAmharic');

$countryEnglish = Configure::read('ApplicationDeployedCountryEnglish');
$cityEnglish = Configure::read('ApplicationDeployedCityEnglish');
$pobox = Configure::read('POBOX');
$email=Configure::read('Email');
$website=Configure::read('Website');
$pdf->AddPage("P");
$pdf->setPageOrientation('P', true, 0);

$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/img/logo.jpg';

$paidImage = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/img/paid.jpg';
$unpaidImage = $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/img/unpaid.jpg';

$invoiceDate = date_create($invoiceDetails['Invoice']['created']);
$formatedInvoiceDate = date_format($invoiceDate, "jS M Y");

if (isset($universityDetails['University']) && !empty($universityDetails['University'])) {
    $vat_reg_no = $universityDetails['University']['vat_registration_number'];
    $tin_number = $universityDetails['University']['tin_number'];
    $vat_reg_date_f = date_create($universityDetails['University']['vat_registration_date']);
    $vat_reg_date = date_format($vat_reg_date_f, "jS M Y");
    $dashanaccount = $universityDetails['University']['dashen_account'];
    $cbeaccount = $universityDetails['University']['cbe_account'];
} else {
    $vat_reg_no = "";
    $tin_number = "";
    $vat_reg_date = "";
    $dashanaccount = "";
    $cbeaccount = "";
}

$campus = '';
if (isset($invoiceDetails['OnlineApplicant']['College']['Campus']['name'])
    && !empty($invoiceDetails['OnlineApplicant']['College']['Campus']['name'])) {
    $campus = $invoiceDetails['OnlineApplicant']['College']['Campus']['name'];
} else if (isset($invoiceDetails['Student']['College']['Campus']['name']) && !empty($invoiceDetails['Student']['College']['Campus']['name'])) {
    $campus = $invoiceDetails['Student']['College']['Campus']['name'];
}
//$header = '<table ><tr><td>';
$header = '<table style="width:100%;">
    	<tr>
    		<td style="text-align:left;">
            <table>
                <tr>
                <td >VAT Reg.No:</td>  <td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $vat_reg_no . '</td>
                </tr>
                 <tr>
                <td>TIN No:</td>  <td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $tin_number . '</td>
                </tr>
                 <tr>
                <td>VAT Reg. Date:</td>  <td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $vat_reg_date . '</td>
                </tr>
                 <tr>
                <td>Dashen Account:</td>  <td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $dashanaccount . '</td>
                </tr>
                  <tr>
                <td>CBE Account:</td>  <td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $cbeaccount . '</td>
                </tr>
            </table>

            </td>

            <td style="text-align:center; font-weight:bold;text-decoration: underline;">
            OFFICE OF THE REGISTRAR <br/>
            <img src="' . $imagePath . '"  width="90" height="81">

            </td>
            <td>
            <table>
                    <tr><td>Invoice ID:</td><td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $invoiceDetails['Invoice']['receipt_code'] . '</td></tr>
                      <tr><td>Invoice Date:</td><td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $formatedInvoiceDate . '</td></tr>
                       <tr><td>Campus:</td><td style="text-align:left; font-weight:bold;text-decoration: underline;">' . $campus . '</td></tr>

            </table>
            </td>

    	</tr>



    	</table> <br/>';

if (
    isset($invoiceDetails['Invoice']['Student']['id']) &&
    !empty($invoiceDetails['Invoice']['Student']['id'])
) {

    $header .= '<table style="width:100%" cellpadding="0">
    <tr>
    <td style="text-align:left;width:45%">
           <table>
           <tr>

		<td style="text-align:left;width:20%;">Name:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline;width:80%">' . ucwords($invoiceDetails['Invoice']['Student']['full_name']) . '</td>

	</tr>

     <tr>

		<td style="text-align:left;width:20%;">Program:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline;width:80%">' . $invoiceDetails['Invoice']['Student']['Program']['name'] . '</td>

	</tr>

         <tr>

		<td  style="text-align:left;width:20%;">Enrollment Type:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline;width:80%;">' . $invoiceDetails['Invoice']['Student']['ProgramType']['name'] . '</td>

	</tr>

     <tr>

		<td style="text-align:left;width:30%">Faculty/School:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline;width:70%">' . $invoiceDetails['Invoice']['Student']['College']['name'] . '</td>

	</tr>

           </table>
    </td>
    <td style="text-align:left;width:25%">
     <table>
           <tr>

		<td style="text-align:left ">Student Type:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline">' . $invoiceDetails['Student']['StudentPaymentType']['name'] . '</td>

	</tr>

    


      <tr>

		<td style="text-align:left;">Department:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline">' . $invoiceDetails['Invoice']['Student']['Department']['name'] .
        '</td>

	</tr>
           </table>

    </td>

    <td style="text-align:left;width:30%">
       <table>
           <tr>

		<td style="text-align:left">ID No:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline">' . $invoiceDetails['Invoice']['Student']['studentnumber']
        . '</td>

	</tr>

     

      <tr>

		<td style="text-align:left;" >Payment Due:</td>
		<td style="text-align:left; font-weight:bold;text-decoration: underline">' .
        $invoiceDetails['Invoice']['due_date']  . '</td>

	</tr>
           </table>

    </td>


    </tr>


</table>';
}

if (isset($invoiceDetails['Invoice']['id']) && !empty($invoiceDetails['Invoice']['id'])) {
    $header .= '<br /><br />
<table style="width:100%">
	<tr>

		<th style="border:1px solid #000000;  width:15%;text-align:left;">S.No</th>
		<th style="border:1px solid #000000; width:20%; text-align:center">Payer Name</th>
		<th style="border:1px solid #000000; width:20%; text-align:center">Payer Email</th>
        <th style="border:1px solid #000000; width:30%; text-align:center">Service</th>
        <th style="border:1px solid #000000;  width:15%;text-align:left;"> Price</th>

	</tr>';



    $header .= '<tr>

		<th style="border:1px solid #000000;  width:15%;text-align:left;">1</th>
         <th style="border:1px solid #000000; width:20%; text-align:center">' . $invoiceDetails['Invoice']['payer_name'] . '</th>
        <th style="border:1px solid #000000;  width:20%; text-align:center">' . $invoiceDetails['Invoice']['payer_email']. '</th>
        <th style="border:1px solid #000000;  width:30%;text-align:left;">' .$invoiceDetails['Invoice']['notes']  . '</th>
		<th style="border:1px solid #000000; width:15%; text-align:center">' . number_format($invoiceDetails['Invoice']['total_amount'] ,
            2, '.', ',') . ' </th>

	</tr>';


    $header .= '</table>';
}

$header .= '<br/><table style="width:100%;">
    	<tr>
    		<td style="text-align:left; font-weight:bold">Note: - Please, don\'t forget to write the Invoice ID on the bank form or on the reason part if transfer via mobile banking,
when deposited the invoice amount to our account. <br/></td>



    	</tr>

<tr>
    		<td style="text-align:left;">Payment methods: (Bank transfer,cash)
For further enquires you can reach us @ '.$website.' or call
Please refer your invoice number on all remittances.</td>
    	</tr>
    	</table>';


$pdf->writeHTML($header);
// Rotate 45 degrees and write the watermarking text

$tipoLetra = "Helvetica";
$tamanoLetra = 35;
$estiloLetra = "B";
// Get the page width/height
$myPageWidth = $pdf->getPageWidth();
$myPageHeight = $pdf->getPageHeight();

// Find the middle of the page and adjust.
$myX = ($myPageWidth / 2) - 75;
$myY = ($myPageHeight / 2) + 25;

// Set the transparency of the text to really light
$pdf->SetAlpha(0.09);
$pdf->StartTransform();
$pdf->Rotate(45, $myX, $myY);
$pdf->SetFont($tipoLetra, $estiloLetra, $tamanoLetra);


if ($payment_details['Invoice']['status'] == 'approved') {
    $pdf->SetTextColor(5, 150, 22);
    $pdf->Text($myX, $myY, "PAID BILL");
} else if ($payment_details['Invoice']['status'] == 'pending' ) {
    $pdf->SetTextColor(227, 37, 16);
    $pdf->Text($myX, $myY, "UNPAID BILL");
}

$pdf->StopTransform();
// Reset the transparency to default
$pdf->SetAlpha(1);


$pdf->Output('Invoice' . '-' . $invoiceDetails['Invoice']['receipt_code'] . '-' . date('Y') . '.pdf', 'I');
/*
I: send the file inline to the browser.
D: send to the browser and force a file download with the name given by name.
F: save to a local file with the name given by name.
S: return the document as a string.
*/