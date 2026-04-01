<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php 
echo __('Course');

?>
		      </h2>
		</div>
		<div class="large-6 columns">
		  <dl><?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Course Title'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $course['Course']['course_title']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Course Code'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $course['Course']['course_code']; ?>
				&nbsp;
			</dd>

 <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Credit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['credit']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('L T L'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_detail_hours']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Course Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['CourseCategory']['name']; ?>
			&nbsp;
		</dd>
                
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Course Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Course Objective'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_objective']; ?>
			&nbsp;
		</dd>
		
		 </dl>
		</div>
		<div class="large-6 columns">
                 <dl>
                   <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Curriculum'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($course['Curriculum']['name'], array('controller' => 'curriculums', 'action' => 'view', $course['Curriculum']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($course['Department']['name'], array('controller' => 'departments', 'action' => 'view', $course['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lecture Attendance Requirement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['lecture_attendance_requirement']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lab Attendance Requirement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['lab_attendance_requirement']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Grade Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($course['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $course['GradeType']['id'])); ?>
			&nbsp;
		</dd>

        
	    <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Prerequisite'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		       <?php 
					if(isset($course['Prerequisite']) && !empty($course['Prerequisite'])) {					echo '<ul>';
					foreach($course['Prerequisite'] as $k=>$v){
				?>
								<li><?php echo $v['PrerequisiteCourse']['course_title'].'('.
$v['PrerequisiteCourse']['course_code'].')'; ?></li>
			  <?php 
					}
				  echo '</ul>';

				} else { ?>
				None

			<?php } ?>
		</dd>


     </dl>
		</div>

		<div class="large-12 columns">
		
<?php 
if (!empty($course['Book'])) { ?>
<div class="related">
	<h3><?php echo __('Related Books');?></h3>
	<?php if (!empty($course['Book'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('S.No'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Author'); ?></th>
		<th><?php echo __('Year'); ?></th>
		<th><?php echo __('Edition'); ?></th>
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($course['Book'] as $book):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $count++;?></td>
			<td><?php echo $book['title'];?></td>
			<td><?php echo $book['author'];?></td>
			<td><?php echo $book['year_of_publication'];?></td>
			<td><?php echo $book['edition'];?></td>
			<!-- <td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'books', 'action' => 'view', $book['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'books', 'action' => 'edit', $book['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'books', 'action' => 'delete', $book['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $book['id'])); ?>
				<?php 
					}
				?>
			</td> -->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<?php 
}

if (!empty($course['Journal'])) {
?>
<div class="related">
	<h3><?php echo __('Related Journals');?></h3>
	<?php if (!empty($course['Journal'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($course['Journal'] as $journal):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $journal['id'];?></td>
			<td><?php echo $journal['title'];?></td>
			<td><?php echo $journal['created'];?></td>
			<td><?php echo $journal['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'journals', 'action' => 'view', $journal['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'journals', 'action' => 'edit', $journal['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'journals', 'action' => 'delete', $journal['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $journal['id'])); ?>
				<?php 
					}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<?php 
}
if (!empty($course['Weblink'])) {
?>
<div class="related">
	<h3><?php echo __('Related Weblinks');?></h3>
	<?php if (!empty($course['Weblink'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Url Address'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($course['Weblink'] as $weblink):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $weblink['id'];?></td>
			<td><?php echo $weblink['title'];?></td>
			<td><?php echo $weblink['url_address'];?></td>
			<td><?php echo $weblink['created'];?></td>
			<td><?php echo $weblink['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'weblinks', 'action' => 'view', $weblink['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'weblinks', 'action' => 'edit', $weblink['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'weblinks', 'action' => 'delete', $weblink['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $weblink['id'])); ?>
				<?php 
					}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<?php } ?>


		</div>
		
	</div>
     </div>
</div>
