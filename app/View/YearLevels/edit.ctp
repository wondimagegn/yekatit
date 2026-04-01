<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Edit Year Level');?>
		      </h2>
		</div>

               <div class="large-12 columns">
		    <?php echo $this->Form->create('YearLevel');?>
	<fieldset>
 		<legend><?php echo __('Edit Year Level'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('department_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
		</div>
        </div>
     </div>
</div>
