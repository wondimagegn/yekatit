<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Add Year Level');?>
		      </h2>
		</div>

                <div class="large-12 columns">
		     <?php echo $this->Form->create('YearLevel');?>	
 	
    <table class="fs13 small_padding">
		<tr>
			<td style="width:13%">Department:</td>
			<td style="width:37%"><?php echo $this->Form->input('department_id',
			array('label'=>false)); ?></td>
		</tr>
		<tr>
			<td style="width:13%">Maximum Numer of year level:</td>
			<td style="width:37%"><?php echo $this->Form->input('numberofyear',array('label'=>false)); ?></td>
		</tr>
    </table>
<?php echo $this->Form->end(
array('label'=>__('Submit'),'class'=>'tiny radius button bg-blue'));?>
		</div>
        </div>
     </div>
</div>
