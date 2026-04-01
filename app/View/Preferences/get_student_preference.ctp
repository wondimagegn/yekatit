<?php ?>
<div class="box">
  <div class="box-body">
	<div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Student Preference List');?>
		      </h2>
		</div>
		<div class="large-12 columns">
               <h3>
                    <?php echo $studentBasic['AcceptedStudent']['full_name'].'('.$studentBasic['AcceptedStudent']['studentnumber'].')';?>
			   </h3>
              <?php if(!empty($studentsPreference)) { ?>
			   <table cellpadding="0" cellspacing="0">
			     <tr>
                 	<th style="border-right: #CCC solid 1px">Department</th>
                	<th style="border-right: #CCC solid 1px">Preference Order</th>
				 </tr>
               
               <?php 
					  
                      foreach($studentsPreference as $k=>$v){
                         echo '<tr><td>'.$v['Department']['name'].'</td><td>'.$v['Preference']['preferences_order'].'</td></tr>';
					 }

				?>
			  </table>
			  <?php } else { ?>
                        <div>There is no department preference filled by the selected student</div>
			 <?php } ?>
		</div>
	</div>
   </div>
</div>

<a class="close-reveal-modal">&#215;</a>
