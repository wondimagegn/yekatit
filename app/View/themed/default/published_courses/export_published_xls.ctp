<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */    
     $xls->setHeader('Published courses');
     $xls->addXmlHeader();
     $xls->setWorkSheetName('Published courses of '.$selected_academic_year.' academic year');
     
     if(!empty($publishedCourses)){
       foreach($publishedCourses as $sk=>$sv){
                 $xls->openRow();
                    $xls->writeString("Courses published for registration of semester $sk of $selected_academic_year academic year ");
                $xls->closeRow();  
                foreach ($sv as $pk => $pv) {            
                       $xls->openRow(); 
                               $xls->writeString("Program ".$pk);
                       $xls->closeRow();  
                       foreach ($pv as $ptk=>$ptv) {
                            $xls->openRow(); 
                               $xls->writeString("Program Type ".$ptk);
                            $xls->closeRow();  
                            foreach ($ptv as $yk=>$yv) {
                                     $xls->openRow(); 
                                        $xls->writeString("Year Level ".$yk);
                                     $xls->closeRow();  
                                      foreach ($yv as $section_name=>$section_value) {
                                        $xls->openRow(); 
                                            $xls->writeString("Section ".$section_name);
                                        $xls->closeRow(); 
                                        $xls->openRow();
                                             $xls->writeString('No.');
                                             $xls->writeString('Course Title');
                                             $xls->writeString('Course Code');
                                             $xls->writeString('Credit');
                                             $xls->writeString('L T L');                                          
                                        $xls->closeRow();
                                        $count=1;
                                        
                                    foreach ($section_value as $type_index=>$section_value_detail) {
                                             $xls->openRow();
                                                $xls->writeString($type_index);
                                             $xls->closeRow();
                                         foreach ($section_value_detail as $publishedCourse) {
                                             $xls->openRow();
                                                $xls->writeString($count++);
                                                $xls->writeString($publishedCourse['Course']['course_title']);
                                                $xls->writeString($publishedCourse['Course']['course_code']);
                                                $xls->writeString($publishedCourse['Course']['credit']);
                                                $xls->writeString($publishedCourse['Course']['course_detail_hours']);
                                               // $xls->closeRow();
                           
                                         }
                                         
                                        }
                                         
                                         
                                     }
                            }
                       }
                        
                }               
                    
        }
     }
    $xls->addXmlFooter();
    exit();
?>
