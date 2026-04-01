<?php 

//BACKUP
if(isset($calendar) && !empty($calendar)) {
?>
		<?php
		 if(!empty($calendar)) {
	
		?>
		
		<?php
		foreach($calendar as $caldar) {
		?>
		<table>		
		<tr>
			<td>
           Program
			</td>
			<td>
			  <?php echo $caldar['calendarDetail']['Program']['name'];?>
			</td>
		</tr>
		<tr>
			<td>
           Program Type
			</td>
			<td>
			 <?php echo $caldar['calendarDetail']['ProgramType']['name'];?>
			</td>
		</tr>		

		<tr>
			<td>
            Department
			</td>
			<td>
			 <?php echo $caldar['departmentname'];?>
			</td>
		</tr>

		<tr>
			<td>
            Year Level
			</td>
			<td>
				<ul>
			  <?php 
			    foreach($caldar['yearlevel'] as $ky=>$kv){
				?>
				  <li>
					<?php echo $kv; ?>
				</li>
			  <?php } ?>
			   </ul>
			</td>
		</tr>

	  <tr>
			<td>
            Course Registration Start
			</td>
			<td>
			 <?php echo $this->Format->humanize_date_short2($caldar['calendarDetail']['AcademicCalendar']['course_registration_start_date']);?>
			</td>
		</tr>
		

	  <tr>
			<td>
            Course Registration End
			</td>
			<td>
			 <?php echo $this->Format->humanize_date_short2($caldar['calendarDetail']['AcademicCalendar']['course_registration_end_date']);?>
			</td>
		</tr>
	
		
	  <tr>
			<td>
            Course Add Start Date
			</td>
			<td>
			 <?php echo $this->Format->humanize_date_short2($caldar['calendarDetail']['AcademicCalendar']['course_add_start_date']);?>
			</td>
		</tr>

		
	  <tr>
			<td>
            Course Add End Date
			</td>
			<td>
			 <?php echo $this->Format->humanize_date_short2($caldar['calendarDetail']['AcademicCalendar']['course_add_end_date']);?>
			</td>
		</tr>

		
	  <tr>
			<td>
            Course Drop Start Date
			</td>
			<td>
			 <?php echo $this->Format->humanize_date_short2($caldar['calendarDetail']['AcademicCalendar']['course_drop_start_date']);?>
			</td>
		</tr>

			
	  <tr>
			<td>
            Course Drop End Date
			</td>
			<td>
			 <?php echo $this->Format->humanize_date_short2($caldar['calendarDetail']['AcademicCalendar']['course_drop_end_date']);?>
			</td>
		</tr>

      </table>
		<?php
		  }
		?>
		
			<?php
		} else {
		  echo '<p>There is no backup. Please make sure that you configured the system to generate database backup regularly.</p>';
		}
		?>
<?php
  }
?>


