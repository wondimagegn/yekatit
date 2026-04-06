<div class="curriculums view">

<div class="smallheading"><?php  __('Curriculum');?></div>

<table>
<tr>
<td>
        <table>
        <tbody>
        <tr><td><?php echo '<strong>Department:</strong>'; ?> &nbsp;&nbsp;<?php echo $this->Html->link($curriculum['Department']['name'], array('controller' => 'departments', 'action' => 'view', $curriculum['Department']['id'])); ?></td></tr>
        <tr><td><?php echo '<strong>Name:</strong>'; ?> &nbsp;&nbsp;<?php echo $curriculum['Curriculum']['name']; ?></td></tr>
        <tr><td><?php 
        echo '<strong>Year Introduced:</strong>';
        
         ?>&nbsp;&nbsp;<?php echo $curriculum['Curriculum']['year_introduced']; ?></td></tr>
        <tr><td><?php
         echo '<strong>Type Of Credit:</strong>'; ?>&nbsp;&nbsp;<?php echo $curriculum['Curriculum']['type_credit']; ?></td></tr>
        <tr><td><?php 
         echo '<strong>Amharic Degree Nomenclature:</strong>';
        
        
        ?>&nbsp;&nbsp;<?php echo $curriculum['Curriculum']['amharic_degree_nomenclature']; ?></td></tr>
        <tr><td><?php 
        
         echo '<strong>English Degree Nomenclature:</strong>'; ?>&nbsp;&nbsp;<?php echo $curriculum['Curriculum']['english_degree_nomenclature']; ?></td></tr>
         <tr><td><?php 
        
         echo '<strong>Certificate Name:</strong>'; ?>&nbsp;&nbsp;<?php echo $curriculum['Curriculum']['certificate_name']; ?></td></tr>
        <tr><td><?php 
            echo '<strong>Minimum Credit Points:</strong>';  
        ?>&nbsp;&nbsp;<?php echo $curriculum['Curriculum']['minimum_credit_points']; ?></td></tr>
        <tr><td> <?php 
        if (!empty($curriculum['Attachment'])) {
        echo "<table>";
        foreach ($curriculum['Attachment'] as $cuk=>$cuv) {
                //$this->Format->humanize_date
                
                
                   
                echo '<tr><td>PDF file uploaded on: '.$this->Format->humanize_date($cuv['created']). '</td></tr>';
                       echo '<tr><td>';
                      echo '<a href='.$this->Media->url($cuv['dirname'].DS.$cuv['basename'],true).'
                      target=_blank>View Attachment</a>';
                      echo '</td></tr>';
               
        } 
        echo "</table>";

        }
        ?>

        <?php 
        ?></td></tr>

        </tbody>
        </table>
</td>
<td width='20%'>
<table>
    <tr>
    <th>S.N<u>o</u></th><th>Name</th><th>Mandatory Credit</th>
    <th>Total Credit</th>
    </tr>
    <?php 
        $cCount=1;
        foreach ($curriculum['CourseCategory'] as $courseCategory=>$courseCategoryValue) {
            echo '<tr>';
            echo '<td>'.$cCount++.'</td><td>'.$courseCategoryValue['name'].'</td><td>'.
            $courseCategoryValue['mandatory_credit'].'</td><td>'.
            $courseCategoryValue['total_credit'].'</td>';
            echo '</tr>';
        }
    ?>
</table>
</td>
</tr>
</table>
<?php 
?>
</div>
<?php 
    if (!empty($curriculum['Course'])) {
?>
<div class="related">
	<h3><?php __('Related Courses');?></h3>
	<?php if (!empty($curriculum['Course'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('S.No'); ?></th>
		<th width="2%"><?php __('Year Level'); ?></th>
		<th width="2%"><?php __('Semester'); ?></th>
		<th><?php __('Course Title'); ?></th>
		<th><?php __('Course Code'); ?></th>
		<th><?php __('Course Category'); ?></th>
	
		<th><?php __('Lecture Attendance Requirement'); ?></th>
		<th><?php __('Lab Attendance Requirement'); ?></th>
		<th><?php __('Grade Type'); ?></th>
		<th><?php __('Credit'); ?></th>
		
		<th width="5%"><?php __('L T L'); ?></th>
		
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($curriculum['Course'] as $course):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		   
			
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $count++;?></td>
			<td><?php echo $course['YearLevel']['name'];?></td>
			<td><?php echo $course['semester'];?></td>
			<td><?php echo $course['course_title'];?></td>
			<td><?php echo $course['course_code'];?></td>
			
			<td><?php echo $course['CourseCategory']['name'];?></td>
			
		
			<td><?php echo $course['lecture_attendance_requirement'];?></td>
			<td><?php echo $course['lab_attendance_requirement'];?></td>
			<td><?php echo $course['GradeType']['type'];?></td>
			<td><?php echo $course['credit'];?></td>
			<td><?php echo $course['course_detail_hours'];?></td>
			
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'courses', 'action' => 'view', $course['id'])); ?>
				<?php  if ($role_id == ROLE_DEPARTMENT)  { ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'courses', 'action' => 'edit', $course['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'courses', 'action' => 'delete', $course['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $course['id'])); ?>
				
				<?php } ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<?php } ?>
