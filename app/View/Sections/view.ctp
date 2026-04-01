<?php ?>
<div class="box">
  <div class="box-body">
	<div class="row">
		<div class="large-12 columns">
		
<div class="sections view">
<h2><?php echo __('Section');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
	
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('College'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($section['College']['name'], array('controller' => 'colleges', 'action' => 'view', $section['College']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($section['Department']['name'], array('controller' => 'departments', 'action' => 'view', $section['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Year Level'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['YearLevel']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Academicyear'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $section['Section']['academicyear']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php if (!empty($section['Student'])) { ?>
<div class="related">
	<h3><?php echo __('Related Students');?></h3>
	<?php if (!empty($section['Student'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('S.No'); ?></th>
		<th><?php echo __('Full Name'); ?></th>
		<th><?php echo __('Studentnumber'); ?></th>
		<th><?php echo __('Department'); ?></th>
		<th><?php echo __('College'); ?></th>
		<th><?php echo __('Gender'); ?></th>
		<th><?php echo __('Program'); ?></th>
		<th><?php echo __('Program Type'); ?></th>
		<th><?php echo __('Email'); ?></th>
	
		<th><?php echo __('Phone Mobile'); ?></th>
		
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($section['Student'] as $student):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $count++;?></td>
			<td><?php echo $student['full_name'];?></td>
		    <td><?php echo $student['studentnumber'];?></td>

		     <?php if(isset($student['Department']['name'])) {?>	
				<td><?php echo $student['Department']['name'];?></td>
			<?php } else {?>
			<td><?php echo "---";?></td>
			<?php }?>
			<td><?php echo $student['College']['name'];?></td>
			<td><?php echo $student['gender'];?></td>
	
			<td><?php echo $student['Program']['name'];?></td>
			<td><?php echo $student['ProgramType']['name'];?></td>
			
			<td><?php echo $student['email'];?></td>
			
			<td><?php echo $student['phone_mobile'];?></td>
			
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'students', 'action' => 'view', $student['id'])); ?>
			
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
