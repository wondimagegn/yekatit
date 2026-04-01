<?php ?>
<div class="box bg-white">
<!-- /.box-header -->
 <div class="box-body pad-forty" style="display: block;">
   <?php echo $this->Form->create('Help',array('action' => 'add','enctype' => 'multipart/form-data'));?>
    <!-- basic form -->
    <div class="row">
	    <div class="large-12 columns">
		<h2><?php echo __('Add Latest Released  Help Document'); ?></h2>
	    </div>
            <div class="large-12 columns">
		
		<div class="row">
                       <div class="large-6 columns">
                          <label>
			Title:
		<?php echo $this->Form->input('Help.title', array('style' => 'width:400px', 'label' => false)); ?>
                          </label>
                        </div>
			<div class="large-6 columns">
                          <label>
				<?php 
				echo $this->Form->input('order');
				?>
                          </label>
                        </div>
                </div>

		<div class="row">
                       <div class="large-6 columns">
                          <label>
				Document Date:
		<?php echo $this->Form->input('Help.document_release_date', array('label' => false,'style'=>'width:100px;')); ?>
                          </label>

                        </div>
			<div class="large-6 columns">
                          <label>
				Version:
		<?php echo $this->Form->input('Help.version', array('label' => false)); ?>
                          </label>
                        </div>
			
                </div>
		
		<div class="row">
			 <div class="large-6 columns">
                          <label>
				Target:
		<?php echo $this->Form->input('Help.target',array('label' =>false, 'type'=>'select', 'multiple'=>'checkbox', 'options' => $roles)); ?>
                          </label>
                        </div>                       
			<div class="large-6 columns">
                          <label>
	<?php 
				echo $this->Form->input('Attachment.0.file', array('type' => 'file'));
?>
                          </label>
                        </div>
                </div>
		<div class="row">
		  <div class="large-6 columns">
			<?php echo $this->Form->end(__('Submit', true));?>
		  </div>
		</div>
	    </div>
      </div>
    </div>
  
  </div>
</div>

