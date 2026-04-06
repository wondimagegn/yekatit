<?php ?>
<div class="colleges view">
<table>
<tbody>
<tr><td class="smallheading"><?php  __('College');?></td></tr>
<tr><td>
		<?php echo $college['College']['name']; ?>
		</td></tr>
<tr><td>
	<?php $i = 0; $class = ' class="altrow"';?></td></tr>
		<tr><td> Located.<?php echo $this->Html->link($college['Campus']['name'], array('controller' => 'campuses', 'action' => 'view', $college['Campus']['id'])); ?></td></tr>
		
		
		<tr><td><?php __('Description'); ?> 
		<?php echo $college['College']['description']; ?>
		</td></tr>
		

</tbody>
</table>
</div>

<div class="related">
	<h3><?php __('Related Departments');?></h3>
	<?php if (!empty($college['Department'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($college['Department'] as $department):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $department['id'];?></td>
			<td><?php echo $department['name'];?></td>
			<td><?php echo $department['description'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'departments', 'action' => 'view', $department['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'departments', 'action' => 'edit', $department['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'departments', 'action' => 'delete', $department['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $department['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Related Notes');?></h3>
	<?php if (!empty($college['Note'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
	
		<th><?php __('Title'); ?></th>
		<th><?php __('Content'); ?></th>
		<th><?php __('College Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Published Date'); ?></th>
		<th><?php __('Start Date'); ?></th>
		<th><?php __('End Date'); ?></th>
		<th><?php __('User Id'); ?></th>
		
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($college['Note'] as $note):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			
			<td><?php echo $note['title'];?></td>
			<td><?php echo $note['content'];?></td>
			<td><?php echo $note['college_id'];?></td>
			<td><?php echo $note['department_id'];?></td>
			<td><?php echo $note['published_date'];?></td>
			<td><?php echo $note['start_date'];?></td>
			<td><?php echo $note['end_date'];?></td>
			<td><?php echo $note['user_id'];?></td>
			
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'notes', 'action' => 'view', $note['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'notes', 'action' => 'edit', $note['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'notes', 'action' => 'delete', $note['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $note['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Related Staffs');?></h3>
	<?php if (!empty($college['Staff'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('College Id'); ?></th>
		<th><?php __('Position Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Title Id'); ?></th>
		<th><?php __('First Name'); ?></th>
		<th><?php __('Middle Name'); ?></th>
		<th><?php __('Ethnicity'); ?></th>
		<th><?php __('Birthdate'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($college['Staff'] as $staff):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			
			<td><?php echo $staff['college_id'];?></td>
			<td><?php echo $staff['position_id'];?></td>
			<td><?php echo $staff['department_id'];?></td>
			<td><?php echo $staff['title_id'];?></td>
			<td><?php echo $staff['first_name'];?></td>
			<td><?php echo $staff['middle_name'];?></td>
			<td><?php echo $staff['ethnicity'];?></td>
			<td><?php echo $staff['birthdate'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'staffs', 'action' => 'view', $staff['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'staffs', 'action' => 'edit', $staff['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'staffs', 'action' => 'delete', $staff['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $staff['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Related Students');?></h3>
	<?php if (!empty($college['Student'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		
		<th><?php __('First Name'); ?></th>
		<th><?php __('Middle Name'); ?></th>
		<th><?php __('Last Name'); ?></th>
		<th><?php __('Gender'); ?></th>
		<th><?php __('Ethnicity'); ?></th>
		<th><?php __('Birthdate'); ?></th>
		<th><?php __('Language'); ?></th>
		<th><?php __('Is Disable'); ?></th>
		<th><?php __('Studentnumber'); ?></th>
		<th><?php __('Admissionyear'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($college['Student'] as $student):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			
			<td><?php echo $student['first_name'];?></td>
			<td><?php echo $student['middle_name'];?></td>
			<td><?php echo $student['last_name'];?></td>
			<td><?php echo $student['gender'];?></td>
			<td><?php echo $student['ethnicity'];?></td>
			<td><?php echo $student['birthdate'];?></td>
			<td><?php echo $student['language'];?></td>
			<td><?php echo $student['is_disable'];?></td>
			<td><?php echo $student['studentnumber'];?></td>
			<td><?php echo $student['admissionyear'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'students', 'action' => 'view', $student['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'students', 'action' => 'edit', $student['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'students', 'action' => 'delete', $student['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $student['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
