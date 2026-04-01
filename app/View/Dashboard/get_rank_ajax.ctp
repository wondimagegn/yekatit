<?php ?>
<div style="margin:0" class="row summary-border-top">
<?php 
if(isset($rank) && !empty($rank)) { 
?>
           <div class="large-12 columns">
                <div class="summary-nest">
                    
				  <p class="text-black"> Your Stand! </p>
                
                </div>

            </div>

            <div class="large-12 columns">
              <?php foreach ($rank as $acsem=>$v) { ?>
					  
		          <div class="row">
                       <div class="large-12 columns"> 
						     <h6 class="text-black" style="text-align:center"><?php echo $acsem; ?> </h6>
				       </div>
                  </div>
                  
                 <div class="row">
                   <div class="large-12 columns"> 
						<table>
							<tr>
                                <td>By</td>
                                <td>Section</td>
                                <td>Batch</td>
                                <td>College</td>  
							</tr>
                           
					<?php if(isset($v['sgpa']) && !empty($v['sgpa'])) { ?>
                 
          					<tr>
                                <td>SGPA</td>
                                <td><?php echo $v['sgpa']['StudentRank']['section_rank'];?></td>
                                <td> <?php echo $v['sgpa']['StudentRank']['batch_rank'];?></td>
                                <td><?php echo $v['sgpa']['StudentRank']['college_rank'];?></td>  
							</tr>
					<?php } ?>
                          
                          
<?php if(isset($v['cgpa']) && !empty($v['cgpa'])) { ?>
                 
          					<tr>
                                <td>CGPA</td>
                                <td><?php echo $v['cgpa']['StudentRank']['section_rank'];?></td>
                                <td> <?php echo $v['cgpa']['StudentRank']['batch_rank'];?></td>
                                <td><?php echo $v['cgpa']['StudentRank']['college_rank'];?></td>  
							</tr>
					<?php } ?>
                          
  
						</table>
				    </div>

                </div>

                 <?php // } ?>

              <?php } ?>
           </div>
<?php } ?>
               
</div>
