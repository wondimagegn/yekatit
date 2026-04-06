<div class="applicablePayments view">
<h2><?php  __('Applicable Payment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($applicablePayment['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $applicablePayment['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tutition Fee'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
		
			 if ($applicablePayment['ApplicablePayment']['tutition_fee']==1) {
		         echo 'Yes';
		    } else {
		         echo 'No'; 
		    }
			
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meal'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
			
			if ($applicablePayment['ApplicablePayment']['meal']==1) {
		         echo 'Yes';
		    } else {
		         echo 'No'; 
		    }
			
			 ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Accomodation'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
			
			 if ($applicablePayment['ApplicablePayment']['accomodation']==1) {
		         echo 'Yes';
		    } else {
		         echo 'No'; 
		    }
			
			
			 ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Health'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			    
			 if ($applicablePayment['ApplicablePayment']['health']==1) {
		         echo 'Yes';
		    } else {
		         echo 'No'; 
		    }
			
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sponsor Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $applicablePayment['ApplicablePayment']['sponsor_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sponsor Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $applicablePayment['ApplicablePayment']['sponsor_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sponsor Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $applicablePayment['ApplicablePayment']['sponsor_address']; ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
