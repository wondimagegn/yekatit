<?php
    App::import('Vendor','tcpdf/tcpdf');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
    
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->SetProtection($permissions = array('modify', 'copy', 'extract', 'assemble'), $user_pass = USER_PASSWORD, $owner_pass = OWNER_PASSWORD, $mode = 0, $pubkeys = null);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('SMiS, '.Configure::read('CompanyName').'');
    $pdf->SetTitle('Mass Course Completion Certificate');
    $pdf->SetSubject('Mass Course Completion Certificate');
    $pdf->SetKeywords('Mass, Course, Completion, Certificate, SMiS');

    $countryAmharic = Configure::read('ApplicationDeployedCountryAmharic'); 
	$cityAmharic = Configure::read('ApplicationDeployedCityAmharic');
	$countryEnglish = Configure::read('ApplicationDeployedCountryEnglish'); 
	$cityEnglish = Configure::read('ApplicationDeployedCityEnglish');
	$pobox = Configure::read('POBOX');

    if (isset($course_completion_certificates) && !empty($course_completion_certificates)) {

        $graduation_certificate_template['GraduationCertificate']['am_title_font_size'] = 14;
        $graduation_certificate_template['GraduationCertificate']['amharic_title'] = 'ለሚመለከተው ሁሉ';

        $graduation_certificate_template['GraduationCertificate']['en_title_font_size'] = 13;
        $graduation_certificate_template['GraduationCertificate']['english_title'] = 'To Whom It May Concern';

        $graduation_certificate_template['GraduationCertificate']['am_content_font_size'] = 15;
        //$graduation_certificate_template['GraduationCertificate']['amharic_content'] = 'ለአቶ/ወ/ሮ/ወ/ሪት STUDENT_NAME በ DEGREE_NOMENCLATURE የትምህርት መስክ  GRADUATION_DATE በመመረቃቸው ይህ የምስክር ወረቀት ተሰጥቷቸዋል፡፡ ውጤታቸውም በአጠቃላይ STUDENT_CGPA  ሲሆን በሀገር  አቀፍ የመውጫ ፈተና EXIT_EXAM_RESULT አማካይ ውጤት ያስመዘገቡ መሆኑን እየገለጽን፤ ዋናው ዲግሪና ትራንስክሪፕት በወጪ መጋራት ውል መሠረት ግዴታቸውን ሲወጡ የሚሰጣቸው ይሆናል፡፡';

        $graduation_certificate_template['GraduationCertificate']['en_content_font_size'] = 13;
        //$graduation_certificate_template['GraduationCertificate']['english_content'] = 'This is to certify that STUDENT_NAME  ' . ($course_completion_certificate['student_detail']['Student']['full_name'] ). ' . (ID NO: ' . ($course_completion_certificate['student_detail']['Student']['studentnumber'] ). ' )Up on graduation in DEGREE_NOMENCLATURE on GRADUATION_DATE. His/her grade is CGPA of STUDENT_CGPA. In addition, he/she scored an average of EXIT_EXAM_RESULT in the National Exit Exam. The original degree and transcript will be issued upon the discharge of cost sharing duty.';

        //$course_completion_certificate['student_detail']['graduated_date'] = '';

        foreach ($course_completion_certificates as $k => $course_completion_certificate) {
            if (!$course_completion_certificate['student_detail']['Student']['graduated']) {
                //SetMargins(Left, Top, Right)
                $pdf->SetMargins(0, 10, 0);
                $pdf->setPageOrientation('L', true, 0);
                $pdf->AddPage("L");
                $pdf->SetLineStyle(array('dash' => 0, 'width' => '1'));
        
        
                $pdf->Image($_SERVER['DOCUMENT_ROOT'] . UNIVERSITY_FULL_PAGE_TRANSPARENT_LOGO_FOR_TCPDF, 0, 15, 180, 180, '', '', '', false, 300, 'C', false, false, 0);
                $pdf->Image($_SERVER['DOCUMENT_ROOT'] . UNIVERSITY_LOGO_HEADER_FOR_TCPDF, 5, 13, 35, 35, '', '', 'N', true, 300, 'C');
                

                // Correct Aamharic and English University Name Posisions

                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
                $pdf->SetFont($fontPath, '', 24, '', true);
                $pdf->MultiCell(107, 7, strtoupper($course_completion_certificate['student_detail']['University']['University']['amharic_name']), 0, 'L', false, 0, 40, 13);
                $pdf->SetFont($fontPath, 'U', 20, '', true);
                $pdf->MultiCell(157, 7, 'ሬጅስትራር ጽ/ቤት', 0, 'L', false, 0, 50, 22);

                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerifBold.ttf');
                $pdf->SetFont($fontPath, '', 17, '', false);
                
                $pdf->MultiCell(107, 7, strtoupper($course_completion_certificate['student_detail']['University']['University']['name']), 0, 'L', false, 0, 190, 14);
                $pdf->SetFont($fontPath, 'U', 14, '', false);
                $pdf->MultiCell(157, 7, 'OFFICE OF THE REGISTRAR', 0, 'L', false, 0, 195, 22);

                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');

                // END Correct Aamharic and English University Name Posisions
                
                
               /*  $pdf->SetFont($fontPath, '', 16, '', true);
                $pdf->MultiCell(157, 7, $cityAmharic . '፡ ' . $countryAmharic, 0, 'C', false, 0, 72, 50);
                
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerifBold.ttf');
                $pdf->SetFont($fontPath, '', 12, '', false);
                $pdf->MultiCell(157, 7, $cityEnglish . ', ' . $countryEnglish, 0, 'C', false, 0, 72, 57);
                
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerif.ttf');
                $pdf->SetFont($fontPath, '', 12, '', false); */
                
                // set visibility only for print or screen
                //$pdf->setVisibility('print');
                /* $pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 3, 'color' => array(211, 211, 211)));
                $pdf->MultiCell(30, 7, "\n\n\n[Photo]\n\n\n\n", 1, 'C', false, 0,30, 33); */
                // restore visibility
                //$pdf->setVisibility('all');
                
                /*  $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
                $pdf->SetFont($fontPath, '', 14, '', true);
                $pdf->MultiCell(100, 7, 'ቀን:', 0, 'L', false, 0, 215, 40);
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
                $pdf->SetFont($fontPath, 'U', 15, '', true);
                $pdf->MultiCell(100, 7, $course_completion_certificate['student_detail']['e_month_name'].' '.$course_completion_certificate['student_detail']['e_day'].'/'.$course_completion_certificate['student_detail']['e_year']. ' ዓ/ም', 0, 'L', false, 0, 224, 40); */
        
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerifBold.ttf');
                $pdf->SetFont($fontPath, '', 12, '', false);
                $pdf->MultiCell(100, 7, 'Date: ', 0, 'L', false, 0, 215, 33);
                $pdf->SetFont($fontPath, 'U', 12, '', false);
                $pdf->MultiCell(100, 7, date('d F, Y').' G.C', 0, 'L', false, 0, 228, 33);
        
                $pdf->MultiCell(100, 7, 'Serial: ', 0, 'L', false, 0, 215, 38);
                $pdf->SetFont($fontPath, 'U', 12, '', false);
                $pdf->MultiCell(100, 7, ' '.$course_completion_certificate['student_detail']['Student']['code'] , 0, 'L', false, 0, 228, 38);
        
                $pdf->MultiCell(100, 7, ' '.'' , 0, 'L', false, 0, 228, 38); 
                
                //$pdf->Line(147, 85, 150, 180);
                $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
                $pdf->Line(149, 55, 149, 170);

                $student_sex_he_she = (strcasecmp(trim($course_completion_certificate['student_detail']['Student']['gender']), 'male') == 0 ? 'He' :(strcasecmp(trim($course_completion_certificate['student_detail']['Student']['gender']), 'female') == 0 ? 'She' : 'He/She'));

                //$student_program_type_name_amh = 'መደበኛ/ማታ/ሳምንት መጨረሻ';
                $student_program_type_name_amh = '________';

                if ($course_completion_certificate['student_detail']['Student']['program_type_id'] == PROGRAM_TYPE_REGULAR) {
                    $student_program_type_name_amh = 'መደበኛ';
                } else if ($course_completion_certificate['student_detail']['Student']['program_type_id'] == PROGRAM_TYPE_EVENING) {
                    $student_program_type_name_amh = 'ማታ';
                } else if ($course_completion_certificate['student_detail']['Student']['program_type_id'] == PROGRAM_TYPE_WEEKEND) {
                    $student_program_type_name_amh = 'ሳምንት መጨረሻ';
                } else if ($course_completion_certificate['student_detail']['Student']['program_type_id'] == PROGRAM_TYPE_SUMMER) {
                    $student_program_type_name_amh = 'ክረምት';
                } else if ($course_completion_certificate['student_detail']['Student']['program_type_id'] == PROGRAM_TYPE_DISTANCE) {
                    $student_program_type_name_amh = 'ርቀት';
                } else if ($course_completion_certificate['student_detail']['Student']['program_type_id'] == PROGRAM_TYPE_ADVANCE_STANDING) {
                    $student_program_type_name_amh = 'የላቀ አቋም';
                }
        
                //Content Amharic
                //$amh_content = 'ተማሪ <span style="font-family:jiret; font-weight:bold; font-size:'.(($graduation_certificate_template['GraduationCertificate']['am_content_font_size']+3)*3).'px;">' . ($course_completion_certificate['student_detail']['Student']['full_am_name']) . '</span> <span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3+2).'px;">(' . (trim($course_completion_certificate['student_detail']['Student']['studentnumber'])). ')</span>  በ'. ($student_program_type_name_amh)  .' የቅድመ ምረቃ ፕሮግራም በ' . $course_completion_certificate['student_detail']['University']['University']['amharic_name'] . ' በ<span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3).'px;">' . ($course_completion_certificate['student_detail']['Student']['academicyear']) . '</span> የትምህርት ዘመን ' . ($student_sex_he_she == 'He' ? 'ተመዝግቦ' :  ($student_sex_he_she == 'She' ? 'ተመዝግባ' : 'ተመዝግቦ/ባ')) .' በ' . ($course_completion_certificate['student_detail']['Curriculum']['specialization_amharic_degree_nomenclature']). ' የባችለር ዲግሪ የኮርስ መስፈርቶችን በ<span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3).'px;">' . ($course_completion_certificate['student_detail']['StudentExamStatus']['cgpa']).'</span> ' . ($student_sex_he_she == 'He' ? 'አጠናቋል' :  ($student_sex_he_she == 'She' ? 'አጠናቃለች' : 'አጠናቋል/ች')) .'። ይሁን እንጂ የተሰጠውን የብሔራዊ የመውጫ ፈተና ' . ($student_sex_he_she == 'He' ? 'ወስዶ' :  ($student_sex_he_she == 'She' ? 'ወስዳ' : 'ወስዶ/ዳ')) .' ከመቶ <span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3).'px;">' . (!empty($course_completion_certificate['student_detail']['ExitExam']['result']) ? $course_completion_certificate['student_detail']['ExitExam']['result'] .'%' : '***') . '</span> ' . ($student_sex_he_she == 'He' ? 'ያስመዘገበ' :  ($student_sex_he_she == 'She' ? 'ያስመዘገበች' : 'ያስመዘገበ/በች')) .' በመሆኑ የማለፊያ ውጤቱን ' . ($student_sex_he_she == 'He' ? 'አላገኘም' :  ($student_sex_he_she == 'She' ? 'አላገኘችም' : 'አላገኘም/ችም')) .'። <br><br>ይህ የምስክር ወረቀት በመስኩ የሚሰጡትን ኮርሶች ' . ($student_sex_he_she == 'He' ? 'ማጠናቀቁን' :  ($student_sex_he_she == 'She' ? 'ማጠናቀቋን' : 'ማጠናቀቁን/ቋን')) .' ለማረጋገጥ የተሰጠ ሲሆን ጊዜያዊ ዲግሪ የሚሰጠው የመውጫ ፈተናውን በድጋሚ ' . ($student_sex_he_she == 'He' ? 'ወስዶ' :  ($student_sex_he_she == 'She' ? 'ወስዳ' : 'ወስዶ/ዳ')) .' የማለፊያ ነጥብ ' . ($student_sex_he_she == 'He' ? 'ሲያስመዘግብ' :  ($student_sex_he_she == 'She' ? 'ስታስመዘግብ' : 'ሲያስመዘግብ/ስታስመዘግብ')) .' ብቻ ይሆናል፡፡';

                $amh_content = 'ተማሪ <span style="font-family:jiret; font-weight:bold; font-size:'.(($graduation_certificate_template['GraduationCertificate']['am_content_font_size']+3)*3).'px;">' . ($course_completion_certificate['student_detail']['Student']['full_am_name']) . '</span> <span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3+2).'px;">(' . (trim($course_completion_certificate['student_detail']['Student']['studentnumber'])). ')</span>  በ'. ($student_program_type_name_amh)  .' የቅድመ ምረቃ ፕሮግራም በ' . $course_completion_certificate['student_detail']['University']['University']['amharic_name'] . ' በ<span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3).'px;">' . ($course_completion_certificate['student_detail']['Student']['academicyear']) . '</span> የትምህርት ዘመን ' . ($student_sex_he_she == 'He' ? 'ተመዝግቦ' :  ($student_sex_he_she == 'She' ? 'ተመዝግባ' : 'ተመዝግቦ/ባ')) .' ' . ($course_completion_certificate['student_detail']['Curriculum']['amharic_degree_nomenclature']). ' የኮርስ መስፈርቶችን በ<span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3).'px;">' . ($course_completion_certificate['student_detail']['StudentExamStatus']['cgpa']).'</span> ' . ($student_sex_he_she == 'He' ? 'አጠናቋል' :  ($student_sex_he_she == 'She' ? 'አጠናቃለች' : 'አጠናቋል/ች')) .'። ይሁን እንጂ የተሰጠውን የብሔራዊ የመውጫ ፈተና ' . ($student_sex_he_she == 'He' ? 'ወስዶ' :  ($student_sex_he_she == 'She' ? 'ወስዳ' : 'ወስዶ/ዳ')) .' ከመቶ <span style="font-family:freeserif; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3).'px;">' . (!empty($course_completion_certificate['student_detail']['ExitExam']['result']) ? $course_completion_certificate['student_detail']['ExitExam']['result'] .'%' : '***') . '</span> ' . ($student_sex_he_she == 'He' ? 'ያስመዘገበ' :  ($student_sex_he_she == 'She' ? 'ያስመዘገበች' : 'ያስመዘገበ/በች')) .' በመሆኑ የማለፊያ ውጤቱን ' . ($student_sex_he_she == 'He' ? 'አላገኘም' :  ($student_sex_he_she == 'She' ? 'አላገኘችም' : 'አላገኘም/ችም')) .'። <p style="line-height:0.6px;">&nbsp;</p> ይህ የምስክር ወረቀት በመስኩ የሚሰጡትን ኮርሶች ' . ($student_sex_he_she == 'He' ? 'ማጠናቀቁን' :  ($student_sex_he_she == 'She' ? 'ማጠናቀቋን' : 'ማጠናቀቁን/ቋን')) .' ለማረጋገጥ የተሰጠ ሲሆን ጊዜያዊ ዲግሪ የሚሰጠው የመውጫ ፈተናውን በድጋሚ ' . ($student_sex_he_she == 'He' ? 'ወስዶ' :  ($student_sex_he_she == 'She' ? 'ወስዳ' : 'ወስዶ/ዳ')) .' የማለፊያ ነጥብ ' . ($student_sex_he_she == 'He' ? 'ሲያስመዘግብ' :  ($student_sex_he_she == 'She' ? 'ስታስመዘግብ' : 'ሲያስመዘግብ/ስታስመዘግብ')) .' ብቻ ይሆናል፡፡';

                //Content English
                //$eng_content = 'This is to certify that <span style="font-family:freeserif; font-weight: bold;">' . ($course_completion_certificate['student_detail']['Student']['full_name']) . ' (' . (trim($course_completion_certificate['student_detail']['Student']['studentnumber'])). ')</span> was admitted  to ' . ($course_completion_certificate['student_detail']['ProgramType']['name']) . ' undergraduate program in '. ($course_completion_certificate['student_detail']['University']['University']['name']) . ' in the ' . ($course_completion_certificate['student_detail']['Student']['academicyear']) . ' academic year. ' . ($student_sex_he_she) . ' has completed  the course requirements for the Bachelor\'s Degree in ' . ($course_completion_certificate['student_detail']['Curriculum']['specialization_english_degree_nomenclature']) . ' in ' . ($course_completion_certificate['student_detail']['StudentExamStatus']['academic_year']) . ' with the CGPA of <span style="font-family:freeserif; font-weight: bold;">' . ($course_completion_certificate['student_detail']['StudentExamStatus']['cgpa']). '</span>. However, ' . (strtolower($student_sex_he_she)). ' <span style="font-family:freeserif; font-weight: bold;">HAS NOT SCORED A PASS MARK (' . (!empty($course_completion_certificate['student_detail']['ExitExam']['result']) ? $course_completion_certificate['student_detail']['ExitExam']['result'] .'%' : '***') . ')</span> in the national exit examination which was administered  on  <span style="font-family:freeserif; font-weight: bold;">' . (date('F, Y', strtotime($course_completion_certificate['student_detail']['ExitExam']['exam_date']))) . '</span>. <br><br> This certificate is issued as confirmation of completion of course works, pending the issuance of temporary degree certificate that fully depends on ' . ($student_sex_he_she == 'He' ? 'his' :  ($student_sex_he_she == 'She' ? 'her' : 'his/her')). ' successful  completion of the national exit examination.';
        
                $eng_content = 'This is to certify that <span style="font-family:freeserif; font-weight: bold;">' . ($course_completion_certificate['student_detail']['Student']['full_name']) . ' (' . (trim($course_completion_certificate['student_detail']['Student']['studentnumber'])). ')</span> was admitted  to ' . ($course_completion_certificate['student_detail']['ProgramType']['name']) . ' undergraduate program in '. ($course_completion_certificate['student_detail']['University']['University']['name']) . ' in the ' . ($course_completion_certificate['student_detail']['Student']['academicyear']) . ' academic year. ' . ($student_sex_he_she) . ' has completed  the course requirements for the ' . ($course_completion_certificate['student_detail']['Curriculum']['english_degree_nomenclature']) . ' in ' . ($course_completion_certificate['student_detail']['StudentExamStatus']['academic_year']) . ' with the CGPA of <span style="font-family:freeserif; font-weight: bold;">' . ($course_completion_certificate['student_detail']['StudentExamStatus']['cgpa']). '</span>. However, ' . (strtolower($student_sex_he_she)). ' <span style="font-family:freeserif; font-weight: bold;">HAS NOT SCORED A PASS MARK (' . (!empty($course_completion_certificate['student_detail']['ExitExam']['result']) ? $course_completion_certificate['student_detail']['ExitExam']['result'] .'%' : '***') . ')</span> in the national exit examination which was administered  in  <span style="font-family:freeserif; font-weight: bold;">' . (date('F, Y', strtotime($course_completion_certificate['student_detail']['ExitExam']['exam_date']))) . '</span>. <p style="line-height:0.6px;">&nbsp;</p> This certificate is issued as confirmation of completion of course works, pending the issuance of temporary degree certificate that fully depends on ' . ($student_sex_he_she == 'He' ? 'his' :  ($student_sex_he_she == 'She' ? 'her' : 'his/her')). ' successful  completion of the national exit examination.';
        
                $pdf->writeHTML('');
                $pdf->writeHTML('<br/>');
        
                $certificate_content = '
                <table style="width:100%; text-align:justify;">
                    <tr>
                        <td style="width:6%"></td>
                        <td style="text-align:center; text-decoration:underline;width:42%; font-family:jiret; font-size:'.($graduation_certificate_template['GraduationCertificate']['am_title_font_size']*5).'px">'.$graduation_certificate_template['GraduationCertificate']['amharic_title'].'</td>
                        <td style="width:5%"></td>
                        <td style="text-align:center;font-weight:bold; font-family:freeserif; text-decoration:underline; width:42%; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_title_font_size']*4).'px">'.$graduation_certificate_template['GraduationCertificate']['english_title'].'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="font-family:jiret; font-weight:bold;line-height:4px; font-size:'.($graduation_certificate_template['GraduationCertificate']['am_content_font_size']*3+2).'px">'.$amh_content.'</td>
                        <td></td>
                        <td style="font-family:freeserif; line-height:4px; font-size:'.($graduation_certificate_template['GraduationCertificate']['en_content_font_size']*3+3).'px">'. $eng_content .'</td>
                    </tr>
                </table>';
        
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
                $pdf->SetFont($fontPath, '', 15, '', true);
                //$pdf->AddFont('bookman_old_style', '', 'bookman_old_style.php');
                $pdf->AddFont('freeserif', '', 'freeserif.php');
                $pdf->AddFont('jiret', '', 'jiret.php');
                //$pdf->SetFont('bookman_old_style', '', 15, '', true);
                $pdf->SetFont('freeserif', '', 15, '', true);
                $pdf->writeHTML($certificate_content);
        
                /* //original one sign for registrar at the middle of the page
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
                $pdf->SetFont($fontPath, '', 15, '', true);
                $pdf->MultiCell(125, '', 'ሬጅስትራር', 0, 'L', false, 0, 125, 195);
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerif.ttf');
                $pdf->SetFont($fontPath, '', 15, '', true);
                $pdf->MultiCell(125, '', '/ Registrar', 0, 'L', false, 0, 145, 195);
                $pdf->Line(95, 195, 200, 195); */

                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/Vendor/tcpdf/fonts/jiret.ttf');
                $pdf->SetFont($fontPath, '', 15, '', true);
                $pdf->MultiCell(50, '', 'ሬጅስትራር', 0, 'L', false, 0, 50, 173);
                $pdf->MultiCell(190, '', 'ፕሬዚዳንት', 0, 'L', false, 0, 190, 192);
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerif.ttf');
                $pdf->SetFont($fontPath, '', 15, '', true);
                $pdf->MultiCell(50, '', '/ Registrar', 0, 'L', false, 0, 70, 173);
                $pdf->MultiCell(200, '', '/ President', 0, 'L', false, 0, 210, 192);


                $pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
                // for registrar sign
                $pdf->Line(30, 172, 115, 172);

                // for president sign ፕሬዚዳንት
                $pdf->Line(170, 190, 250, 190);


                $style = array();
                
                $pdf->write2DBarcode(BASE_URL_HTTPS.'pages/check_graduate/'.str_replace('/','-',$course_completion_certificate['student_detail']['Student']['studentnumber']), 'QRCODE,H', 260, 180, 20, 20, $style, 'N');
                $pdf->SetFont($fontPath, '', 8, '', true);
                $pdf->Text(259, 176, $course_completion_certificate['student_detail']['Student']['studentnumber']);
        
                // set alpha to semi-transparency
                $pdf->SetAlpha(0.3);
        
                // draw gray square
                $pdf->SetFillColor(211, 211, 211);
                $pdf->SetDrawColor(211, 211, 211);
                $pdf->Rect(18, 182, 60, 20, 'DF');
                
                // restore full opacity
                $pdf->SetAlpha(1);
        
                $fontPath = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/app/webroot/fonts/FreeSerif.ttf');
                $pdf->SetFont($fontPath, '', 12, '', false);
                $pdf->MultiCell(100, 7, 'Tel: '.$course_completion_certificate['student_detail']['University']['University']['telephone'], 0, 'L', false, 0, 20, 185);
                $pdf->MultiCell(100, 7, 'Fax: '.$course_completion_certificate['student_detail']['University']['University']['fax'].'', 0, 'L', false, 0, 20, 190);
                $pdf->MultiCell(100, 7, 'P.O.Box: '. $course_completion_certificate['student_detail']['University']['University']['p_o_box'] , 0, 'L', false, 0, 20, 195);
        
                // reset pointer to the last page
                $pdf->lastPage();
            }
        }

        //output the PDF to the browser
        if (count($course_completion_certificates) == 1) {
            $pdf->Output('Course Completion Certificate ' . (str_replace('/', '-', $course_completion_certificates[0]['student_detail']['Student']['studentnumber'])). '_' . $course_completion_certificates[0]['student_detail']['Student']['first_name'] . '_' . $course_completion_certificates[0]['student_detail']['Student']['middle_name'] . '_' . $course_completion_certificates[0]['student_detail']['Student']['last_name'] . '_' . date('Y-m-d') . '.pdf', 'I');
        } else {
            $pdf->Output('Course Completion Certificate ' . date('Y-m-d') . '.pdf', 'I');
        }
    }
    
    /*
    I: send the file inline to the browser.
    D: send to the browser and force a file download with the name given by name.
    F: save to a local file with the name given by name.
    S: return the document as a string.
    */