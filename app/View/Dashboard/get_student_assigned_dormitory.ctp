<?php ?>
<div style="margin:0" class="row summary-border-top">
		<div class="large-12 columns">
                <div class="school-timetable">
                    
				 
                   <?php 
					if(!empty($dormAssignedStudent)) {
                        	?>
			          
 <h6><i class=" fontello-home-outline"></i> Block <span class="bg-blue"><?php echo $dormAssignedStudent['Dormitory']['DormitoryBlock']['block_name'];?></span></h6>
             <h6><i class=" fontello-home-outline"></i> Floor <span class="bg-blue"><?php echo $dormAssignedStudent['Dormitory']['floor'];?></span></h6>
			
		    <h6><i class=" fontello-home-outline"></i> Room <span class="bg-green"><?php echo $dormAssignedStudent['Dormitory']['dorm_number'];?></span></h6>
 
		 <h6><i class=" fontello-home-outline"></i> Capacity <span class="bg-blue"><?php echo $dormAssignedStudent['Dormitory']['capacity'];?></span></h6>
					<?php 
					
				echo $this->HTML->link('Assigned','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalUpgrade',
'data-reveal-ajax'=>'/dormitoryAssignments/assignedStudents/'.$dormAssignedStudent['Dormitory']['id']));
					?>
					
			<?php 				
					} 

				?>
                </div>
      </div>
</div>

