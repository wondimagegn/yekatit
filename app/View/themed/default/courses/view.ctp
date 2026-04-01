<div class="courses view">
<h2><?php  __('Course');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Credit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['credit']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('L T L'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_detail_hours']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['CourseCategory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Objective'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['course_objective']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Curriculum'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($course['Curriculum']['name'], array('controller' => 'curriculums', 'action' => 'view', $course['Curriculum']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($course['Department']['name'], array('controller' => 'departments', 'action' => 'view', $course['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lecture Attendance Requirement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['lecture_attendance_requirement']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lab Attendance Requirement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['lab_attendance_requirement']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($course['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $course['GradeType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $course['Course']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php 
if (!empty($course['Book'])) { ?>
<div class="related">
	<h3><?php __('Related Books');?></h3>
	<?php if (!empty($course['Book'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('S.No'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Author'); ?></th>
		<th><?php __('Year'); ?></th>
		<th><?php __('Edition'); ?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'books', 'action' => 'view', $book['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'books', 'action' => 'edit', $book['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'books', 'action' => 'delete', $book['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $book['id'])); ?>
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
	<h3><?php __('Related Journals');?></h3>
	<?php if (!empty($course['Journal'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'journals', 'action' => 'view', $journal['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'journals', 'action' => 'edit', $journal['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'journals', 'action' => 'delete', $journal['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $journal['id'])); ?>
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
	<h3><?php __('Related Weblinks');?></h3>
	<?php if (!empty($course['Weblink'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Url Address'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'weblinks', 'action' => 'view', $weblink['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'weblinks', 'action' => 'edit', $weblink['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'weblinks', 'action' => 'delete', $weblink['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $weblink['id'])); ?>
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
<?php 
if (!empty($course['Student'])) {

?>

<div class="related">
	<h3><?php __('Related Students');?></h3>
	<?php if (!empty($course['Student'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('S.No'); ?></th>
		<th><?php __('Full Name'); ?></th>
		<th><?php __('Student Number'); ?></th>
		<th><?php __('Program'); ?></th>
		<th><?php __('Program Type'); ?></th>
		
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($course['Student'] as $student):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $count++;?></td>
		   <td><?php echo $student['full_name'];?></td>
			<td><?php echo $student['studentnumber'];?></td>
			
			<td><?php echo $student['Program']['name'];?></td>
			<td><?php echo $student['ProgramType']['name'];?></td>
			
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'students', 'action' => 'view', $student['id'])); ?>
				<?php
					if($role_id == ROLE_DEPARTMENT) {
				?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'students', 'action' => 'edit', $student['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'students', 'action' => 'delete', $student['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $student['id'])); ?>
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
