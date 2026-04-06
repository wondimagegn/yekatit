<?php echo $this->Form->create('Page',
array('controller'=>'pages',
'action'=>'official_request_tracking',
'method'=>'post')); ?>
<div class="box">
     <div class="box-body">
       <div class="row">
		  	<div class="large-12 columns">

		  		<h3> <?php echo __('Official Transcript Request Status.'); ?>
		  		</h3>
		  	</div>
		  	<div class="large-12 columns">
			   <?php echo $this->Form->input('OfficialTranscriptRequest.trackingnumber',array('label'=>'','placeholder'=>'Tracking number')); ?>
				  		   
		   </div>   
		   <div class="large-12 columns">
			   <?php 
			       echo $this->Form->end(
array('label'=>__('Search',true),'class'=>'tiny radius button bg-blue'));
		
?> 
		   </div>
		   <?php if(isset($request) && !empty($request)){ ?>
		   <div class="large-12 columns">
		   		<table>
		   			<thead>
						<tr>  
							<th>Name</th>
							<th colspan="3"><?php echo $request['OfficialTranscriptRequest']['first_name'].' '.$request['OfficialTranscriptRequest']['father_name'].' '.$request['OfficialTranscriptRequest']['grand_father']; ?>
							</th>
						</tr>
						<tr>  
							<th>ID</th>
							<th colspan="3"><?php 
							echo $request['OfficialTranscriptRequest']['studentnumber']; ?>
							</th>
						</tr>
						<tr>
			   				<th>Status</th>
			   				<th>Request Date</th>
			   				<th>Remark</th>
		   				</tr>
		   			</thead>
		   			<tbody>
		   				<?php if(isset($request['OfficialRequestStatus']) && !empty($request['OfficialRequestStatus'])) { 
		   					foreach($request['OfficialRequestStatus'] as $kk=>$kv){
		   				?>
		   				<tr>
			   				
			   				<td>
			   				<?php 
			   					echo $statuses[$kv['status']]; 	
			   				?>
			   				</td>
			   				<td>
			   				<?php 
			   					
			   					
			   					echo date("F j, Y, g:i a",
			   					 strtotime($kv['created'])); 
			   				?>
			   				</td>
			   				<td>
			   				<?php 
			   					
			   					echo $kv['remark'];
			   				?>
			   				</td>
		   				</tr>
		   				<?php 
		   				}
		   				} ?>
		   			</tbody>
		   		</table>
		   </div>
		   <?php } ?>
		</div>
	  </div>
</div>
<?php echo $this->Form->end();?>
