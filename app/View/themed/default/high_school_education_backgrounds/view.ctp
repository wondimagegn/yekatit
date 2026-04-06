<div class="highSchoolEducationBackgrounds view">
<h2><?php  __('High School Education Background');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Town'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['town']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Zone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['zone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Region'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['region']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('School Level'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['school_level']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $highSchoolEducationBackground['HighSchoolEducationBackground']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit High School Education Background', true), array('action' => 'edit', $highSchoolEducationBackground['HighSchoolEducationBackground']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete High School Education Background', true), array('action' => 'delete', $highSchoolEducationBackground['HighSchoolEducationBackground']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $highSchoolEducationBackground['HighSchoolEducationBackground']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List High School Education Backgrounds', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New High School Education Background', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Students');?></h3>
	<?php if (!empty($highSchoolEducationBackground['Student'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('First Name'); ?></th>
		<th><?php __('Middle Name'); ?></th>
		<th><?php __('Last Name'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Accepted Student Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('College Id'); ?></th>
		<th><?php __('Gender'); ?></th>
		<th><?php __('Ethnicity'); ?></th>
		<th><?php __('Nationality'); ?></th>
		<th><?php __('Place Of Birth'); ?></th>
		<th><?php __('Marital Status'); ?></th>
		<th><?php __('Birthdate'); ?></th>
		<th><?php __('Language'); ?></th>
		<th><?php __('Is Disable'); ?></th>
		<th><?php __('Studentnumber'); ?></th>
		<th><?php __('Admissionyear'); ?></th>
		<th><?php __('Estimated Grad Date'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('Region Id'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th><?php __('Address1'); ?></th>
		<th><?php __('Program Id'); ?></th>
		<th><?php __('Program Type Id'); ?></th>
		<th><?php __('High School Education Background Id'); ?></th>
		<th><?php __('Higher Education Id'); ?></th>
		<th><?php __('Zone Subcity'); ?></th>
		<th><?php __('Woreda'); ?></th>
		<th><?php __('Kebele'); ?></th>
		<th><?php __('House Number'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Email Alternative'); ?></th>
		<th><?php __('Phone Home'); ?></th>
		<th><?php __('Phone Mobile'); ?></th>
		<th><?php __('Pobox'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($highSchoolEducationBackground['Student'] as $student):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $student['id'];?></td>
			<td><?php echo $student['first_name'];?></td>
			<td><?php echo $student['middle_name'];?></td>
			<td><?php echo $student['last_name'];?></td>
			<td><?php echo $student['user_id'];?></td>
			<td><?php echo $student['accepted_student_id'];?></td>
			<td><?php echo $student['department_id'];?></td>
			<td><?php echo $student['college_id'];?></td>
			<td><?php echo $student['gender'];?></td>
			<td><?php echo $student['ethnicity'];?></td>
			<td><?php echo $student['nationality'];?></td>
			<td><?php echo $student['place_of_birth'];?></td>
			<td><?php echo $student['marital_status'];?></td>
			<td><?php echo $student['birthdate'];?></td>
			<td><?php echo $student['language'];?></td>
			<td><?php echo $student['is_disable'];?></td>
			<td><?php echo $student['studentnumber'];?></td>
			<td><?php echo $student['admissionyear'];?></td>
			<td><?php echo $student['estimated_grad_date'];?></td>
			<td><?php echo $student['country_id'];?></td>
			<td><?php echo $student['region_id'];?></td>
			<td><?php echo $student['city_id'];?></td>
			<td><?php echo $student['address1'];?></td>
			<td><?php echo $student['program_id'];?></td>
			<td><?php echo $student['program_type_id'];?></td>
			<td><?php echo $student['high_school_education_background_id'];?></td>
			<td><?php echo $student['higher_education_id'];?></td>
			<td><?php echo $student['zone_subcity'];?></td>
			<td><?php echo $student['woreda'];?></td>
			<td><?php echo $student['kebele'];?></td>
			<td><?php echo $student['house_number'];?></td>
			<td><?php echo $student['email'];?></td>
			<td><?php echo $student['email_alternative'];?></td>
			<td><?php echo $student['phone_home'];?></td>
			<td><?php echo $student['phone_mobile'];?></td>
			<td><?php echo $student['pobox'];?></td>
			<td><?php echo $student['created'];?></td>
			<td><?php echo $student['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'students', 'action' => 'view', $student['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'students', 'action' => 'edit', $student['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'students', 'action' => 'delete', $student['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $student['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
