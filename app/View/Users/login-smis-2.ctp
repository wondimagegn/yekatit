<?php 
?>
<!-- Container Begin -->
<div class="large-offset-4 large-4 columns">
  <div class="box bg-white-transparent">
    <!-- Profile -->
    <div class="profile">
        		
	<img src="/img/amulogo.png">
	
     
	
       <h3>AMU | SMiS<small>2.0</small></h3>
        <br/>
        <h6 style="font-size:0.6rem;">We grow in the esteem of future generations.</h6>


    </div>
    <!-- End of Profile -->
    
    <!-- /.box-header -->
    <div class="box-body " style="display: block;">
            <div class="row">
                  <div class="large-12 columns">
                      <div class="row">
			 <div class="edumix-signup-panel">
		   
			<?php
			$flash_message = $this->Session->flash();
			if(!empty($flash_message)) {
			?>	
			<?php echo $flash_message; ?> 
			<?php
			}
			?>

		<?php echo ($this->Form->create('User', array('action' => 'login')));?>

 <div class="row collapse">
	<div class="small-2  columns">
	    <span class="prefix bg-green"><i class="text-white icon-user"></i></span>
	</div>
	<div class="small-10  columns">
	     <?php echo($this->Form->input('username', array('placeholder'=>'Username','label'=>false, 'autocomplete' => "off",'class'=>'username'))); ?>
	</div>
</div>


<div class="row collapse">
	<div class="small-2  columns">
	    <span class="prefix bg-green"><i class="text-white icon-lock"></i></span>
	</div>
	<div class="small-10  columns">
	     <?php echo ($this->Form->input('password', array('label'=>false, 'autocomplete' => "off",'placeholder'=>'Password'))); ?>
	</div>
</div>
 <?php
	if(isset($mathCaptcha)){
	?>
	
	<div class="row collapse">
		<div class="small-7  columns">
		   Please enter the sum of 
<?php echo($mathCaptcha); ?>
		</div>
		<div class="small-3 columns">
		   <?php echo $this->Form->input('security_code', array('style' => 'height:20px; width:70px; border:1px solid #073e8e; background-color:transparent;', 'label' => false, 'div' => false)); ?>  
		</div>
		<div class="small-2 columns">
			<?php echo ($this->Form->Submit('Enter', array('div' => false,'class' => 'submitbutton', 'style' => 'background-color:#336eb5;color:#F5F5F5; font-weight:bold'))); ?>
		</div>
	</div>	
	<?php
	 }
	?>

 <p>

<?php echo $this->Html->link(__('Forget Password ?', true), array('action' => 'forget'),array('class'=>'forgot-button')); ?> 
                                        </p>
           
<div class="login-button">
           
 <?php echo($this->Form->Submit('Login', array('div' => false))); ?>
</div>
                    <br>
<!--
  <p> This is a restricted network. Use of this network, its equipment, and resources is monitored at all times and requires explicit permission from the system adminstrator. If you do not have this permission in writing, you are violationg the regulations of this network and can and will be prosecuted to the fullest extent of law. By continuing into this system, you are acknowledging that you are aware of and agree to these terms.

			</p>   
-->
<?php echo($this->Form->end()); ?>                      

			 </div>
		      </div>
		  </div>
	    </div>

    </div>


  </div>
</div>
