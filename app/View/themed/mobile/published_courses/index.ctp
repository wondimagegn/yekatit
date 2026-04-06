<?php echo $this->Form->create('PublishedCourse', array('action' => 'index'));?> 
<div class="publishedCourses index">
<?php 
    if (!isset($search_published_course)) {
?>
<table cellpadding="0" cellspacing="0">
<tr><td colspan=2 class="smallheading"> View published courses.</td></tr>
<tr><td colspan=2>
<?php 
			echo $this->Form->input('PublishedCourse.academic_year',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--")); ?>
</td></tr>
<tr> 
	
	<?php 
	      echo '<tr><td>'. $this->Form->input('PublishedCourse.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>'; 
	?>
	<td> 
			<?php 
			//echo $this->Form->input('PublishedCourse.year_level_id',array('empty'=>"--Select Year Level--")); ?>
	</td>
	<tr>
	
	<?php 
	if ($role_id==ROLE_REGISTRAR) {
	?>
	<!--
	<tr><td><?php echo $this->Form->input('AcceptedStudent.college_id',array(
            'empty'=>"--Select College --",'selected'=>isset($selected_college)?$selected_college:'')); ?></td></tr>
            -->
      <?php
      
      }       
      ?>
	<tr><td><?php echo $this->Form->end(__('Search',true)); ?> </td>	
	
</tr></table>
<?php } ?>

<?php 


if (isset($publishedCourses)) { 
 
	
    echo "<table><tbody><tr><td>".$this->Html->link($this->Html->image("pdf_icon.gif",array("alt"=>"Print to PDF")),
array('action'=>"print_published_pdf"),array('escape'=>false))." Print</td><td>".$this->Html->link($this->Html->image("xls-icon.gif",array('alt'=>'Export To Xls')),array('action'=>"export_published_xls"),array('escape'=>false))." Export</td></tr></tbody></table>";

   foreach($publishedCourses as $sk=>$sv){
            
            if (!empty($sv)) {
                 echo "<div class='fs15' style='font-weight:bold'> Academic Year: ".$academic_year."</div>";
                echo "<div class='fs15' style='font-weight:bold'> Semester: ".$sk."</div>";
                $count=1;
                foreach ($sv as $pk => $pv) {
                    if (!empty($pk)) {
                            echo "<div class='fs16'> Program:".$pk."</div>";
                       foreach ($pv as $ptk=>$ptv) {
                       
                         if (!empty($ptk)) {
                                 echo "<div class='fs16'> Program Type: ".$ptk."</div>";
                               
                              foreach ($ptv as $yk=>$yv) {
                                  if (!empty($yv)) {
                                     echo "<div class='fs16'> Year Level: ".$yk."</div>";
                                     foreach ($yv as $section_name=>$section_value) {
                                      echo "<div class='fs16'> Section : ".$section_name."</div>";
                                    
                                      echo "<table cellpadding=0 cellspacing=0>";
                                      ?>
                                       <tr>
                                           <th>S.N<u>o</u></th>
			      
			        <th><?php echo 'Course Title';?></th>
			        <th><?php echo 'Course Code';?></th>
			        <th><?php echo 'Credit';?></th>
			        <th><?php echo 'L T L';?></th>
			</tr>
                                      <?php  
                                    foreach ($section_value as $type_index=>$section_value_detail) {
                                       echo '<tr><td colspan=5 class="fs16">'.$type_index.'</td></tr>';
                                  
                                      foreach ($section_value_detail as $publishedCourse) {
                                          
                                           ?>
                                          
                                           <?php 
                                            if (!empty($publishedCourse)) {
                                              
	                    $i = 0;
	                 
	                        
		                    $class = null;
		                    if ($i++ % 2 == 0) {
			                    $class = ' class="altrow"';
		                    }
		                    ?>
		                    <tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
				<td>
			<?php echo $this->Html->link($publishedCourse['Course']['course_title'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['Course']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($publishedCourse['Course']['course_code'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['Course']['id'])); ?>
		</td>
		<td>
			<?php echo $publishedCourse['Course']['credit']; ?>
		</td>
		<td>
			<?php echo $publishedCourse['Course']['course_detail_hours']; ?>
		</td>
		<!-- <td class="actions">
			
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $publishedCourse['PublishedCourse']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $publishedCourse['PublishedCourse']['id'])); ?>
		</td>  -->

	</tr>
		                    
		                    <?php   
		
		            
                                            }
                                         
                                       }
                                       
                                       } // type
                                         echo "</table>";
                                     } 
                                     
                                     } //section end 
                                 } // end year level
                         }
                    
                      }
                   }
                }
         }   
   }


?>  

<?php 
}

if (isset($publishedCoursesCollege) && !empty($publishedCoursesCollege)) {
     echo "<div class='largeheading'> Academic Year: ".$academic_year."</div>";
     echo "<div class='largeheading'> Semester: ".$semester."</div>";    
     $count=1;
     foreach ($publishedCoursesCollege as $section_name=>$section_value) {
                                      echo "<div class='fs16'> Section : ".$section_name."</div>";
                                      echo "<div class='fs16'> Year Level : Freshman </div>";
                                      echo "<table cellpadding=0 cellspacing=0>";
                                      ?>
                                       <tr>
                                           <th><?php echo 'Id';?></th>
			      
			        <th><?php echo 'Course Title';?></th>
			        <th><?php echo 'Course Code';?></th>
			        <th><?php echo 'Credit';?></th>
			        <th><?php echo 'L T L';?></th>
			</tr>
                                      <?php  
                                         foreach ($section_value as $type_index=>$section_value_detail) {
                                       echo '<tr><td colspan=5 class="fs16">'.$type_index.'</td></tr>';
                                  
                                      foreach ($section_value_detail as $publishedCourse) {
                                          
                                           ?>
                                          
                                           <?php 
                                            if (!empty($publishedCourse)) {
                                              
	                    $i = 0;
	                 
	                        
		                    $class = null;
		                    if ($i++ % 2 == 0) {
			                    $class = ' class="altrow"';
		                    }
		                    ?>
		                    <tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
				<td>
			<?php echo $this->Html->link($publishedCourse['Course']['course_title'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['Course']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($publishedCourse['Course']['course_code'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['Course']['id'])); ?>
		</td>
		<td>
			<?php echo $publishedCourse['Course']['credit']; ?>
		</td>
		<td>
			<?php echo $publishedCourse['Course']['course_detail_hours']; ?>
		</td>
		<!-- <td class="actions">
			
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $publishedCourse['PublishedCourse']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $publishedCourse['PublishedCourse']['id'])); ?>
		</td>  -->

	</tr>
		                    
		                    <?php   
		
		            
                                            }
                                         
                                       }
                                  }
                                echo "</table>";
                    } 
   }

?>
</div>
