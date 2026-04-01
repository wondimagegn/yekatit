<?php echo $this->Form->create('Position');?>
<div class="box bg-white">
<!-- /.box-header -->
 <div class="box-body pad-forty" style="display: block;">
    <!-- basic form -->
    <div class="row">
    	<div class="large-12 columns">
		<h2><?php echo __('Add Position'); ?></h2>
	</div>
	<div class="large-12 columns">
		<div class="row">
                       <div class="large-6 columns">
                       
		<?php echo $this->Form->input('position',array('label' => 'Position')); ?>

                         
                        </div>

						 <div class="large-6 columns">
                    	<?php echo $this->Form->input('description', array('label' => 'Description')); ?>   
					                   
                        </div>
         </div>
		<div class="row">
				 <div class="large-6 columns">
				<?php echo $this->Form->end(array('label'=>__('Submit'),
'class'=>'tiny radius button bg-blue'));?>
				 </div>
		</div>
	  </div>
    </div>
 </div>
</div>
