<div class="offices view">
<h2><?php  __('Office');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
	
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telephone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['telephone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Alternative Telephone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['alternative_telephone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Alternative Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['alternative_email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $office['Office']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<div class="smallheading"><?php __('Related Taken Properties');?></div>
   
	<?php if (!empty($office['TakenProperty'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th>S.N<u>o</u></th>
		
		<th><?php __('Student '); ?></th>
		<th><?php __('Office '); ?></th>
		<th><?php __('Item Name'); ?></th>
		<th><?php __('Taken Date'); ?></th>
		<th><?php __('Returned'); ?></th>
		<th><?php __('Return Date'); ?></th>
		<th><?php __('Remark'); ?></th>
		
	</tr>
	<?php
		$i = 0;
		$start=1;
		foreach ($office['TakenProperty'] as $takenProperty):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $start++;?></td>
			
			<td><?php echo $takenProperty['Student']['full_name'];?></td>
			<td><?php echo $takenProperty['Office']['name'];?></td>
			<td><?php echo $takenProperty['name'];?></td>
			<td><?php echo $takenProperty['taken_date'];?></td>
			<td><?php 
			        if ($takenProperty['returned']==1) {
			            echo 'Yes';
			        } else {
			            echo 'No';
			        }
			       
			    
			    ?></td>
			<td><?php echo $takenProperty['return_date'];?></td>
			<td><?php echo $takenProperty['remark'];?></td>
			
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
