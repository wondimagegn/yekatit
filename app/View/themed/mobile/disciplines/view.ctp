<div class="disciplines view">

	<div class="smallheading"><?php __('View  Discipline Detail'); ?></div>
	<table>
	<tr>
	    <td colspan=2>
	     <?php  echo $this->element('student_basic'); ?>
	    </td>
	</tr>
	    <tr>
	     <td colspan="2">
	        <table>
	           <tr>
	               <td class="fs16" colspan="2">
	                 <?php 
	                    __('Discipline case details.'); 
	                 ?>
	               </td>
	           </tr>
	            <?php
		         
		            echo '<tr>';
		                echo '<td>Discipline Date:</td>';
		                echo '<td>'.$this->Format->short_date($discipline['Discipline']['discipline_taken_date']).'</td>';
		
		               
		            echo '</tr>'; 
		            echo '<tr>';
		                echo '<td> Title:</td>';
		                echo '<td>'.$discipline['Discipline']['title'].'</td>';
		
		               
		            echo '</tr>'; 
		            echo '<tr>';
		                echo '<td> Description:</td>';
		                echo '<td>'.$discipline['Discipline']['description'].'</td>';
		
		               
		            echo '</tr>'; 
		          
		            
		            //
		         
	        ?>
	        </table>
	    
	    </td>
	 
	    </tr>
	
	</table>
	
</div>
