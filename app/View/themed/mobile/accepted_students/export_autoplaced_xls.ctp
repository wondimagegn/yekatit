<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */
    
     $xls->setHeader('Auto Placement Result');
     $xls->addXmlHeader();
     $xls->setWorkSheetName('Auto Placement Result');
     
     if(!empty($autoplacedstudents)){
        $summery=$autoplacedstudents['auto_summery'];
        $xls->openRow();
                $xls->writeString("Summery of Auto Placement");
        $xls->closeRow();
        $xls->openRow();
                $xls->writeString("Department");
                $xls->writeString("Competitive Assignment");
                $xls->writeString("Privilaged Quota Assignment");
        $xls->closeRow();
        foreach ($summery as $sk=>$sv){  
            $xls->openRow();
                $xls->writeString($sk);
                $xls->writeString($sv['C']);
                $xls->writeString($sv['Q']);
            $xls->closeRow();
        
        }
        unset($autoplacedstudents['auto_summery']);
         ?>
       
		<?php 
		
       
        foreach($autoplacedstudents as $key =>$data){
                $xls->openRow();
                    $xls->writeString($key);
                $xls->closeRow();      
                $xls->openRow();
                     $xls->writeString('Full Name');
                     $xls->writeString('Sex');
                     $xls->writeString('Student Number');
                     $xls->writeString('EHEECE Result');
                    // $xls->writeString('EHEECE_total_results');
                     $xls->writeString('Department');
                     $xls->writeString('Preference Order');
                     $xls->writeString('Placement Type');
                     $xls->writeString('Placement Based');
                $xls->closeRow();
                foreach($data as $acceptedStudent){
                         $xls->openRow();
                             $xls->writeString($acceptedStudent['AcceptedStudent']['full_name']);
                             $xls->writeString($acceptedStudent['AcceptedStudent']['sex']);
                             $xls->writeString($acceptedStudent['AcceptedStudent']['studentnumber']);
                             $xls->writeString($acceptedStudent['AcceptedStudent']['EHEECE_total_results']);
                             $xls->writeString($acceptedStudent['Department']['name']);
                             //preference
                             if(!empty($acceptedStudent['Preference'])){
		                               foreach($acceptedStudent['Preference'] as $pk=>$pv){
		                                if($pv['department_id']==$acceptedStudent['Department']['id']){
	                                        
	                                        	 $xls->writeString($pv['preferences_order']); 
	                                        	break;
	                                	}
		                            }
		                     } else {
		                        $xls->writeString(null); 
		                     }
                            
                            $xls->writeString($acceptedStudent['AcceptedStudent']['placementtype']);
                            $xls->writeString($acceptedStudent['AcceptedStudent']['placement_based']=="C" ? "Competitive":"Privilaged Quota");
                      $xls->closeRow();
                }
        }
     }
    $xls->addXmlFooter();
    exit();
?>
