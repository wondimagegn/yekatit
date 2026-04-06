
<?php 

echo $this->Form->create('ExamGrade', 
    array('controller' => 'exam_grades','action' => 'mass_import_grade', 'type' => 'file'));

?>


<div class="box">
     <div class="box-body pad-forty">
       <div class="row">
             <div class="large-12 columns">
                <p class="fs16">
<span class="rejected">Be-aware:</span> Before importing the excel ,make sure that the value of student number, academic year, course code, semester, grade field as listed below. Click the link below to download the excel template that shows 
you how you can store the data in excel that are compatible with the system database. 
    <a href="/files/template/GradeImport.xls">Download Import Template!</a>
</p>
             </div>
		   	 <div class="large-12 columns">
		   	 	   <h4><?php echo __(' Mass Grade Entry s'); ?></h4>		
		   	 </div>
			  <div class="large-12 columns">
                Student List 

				   <?php    
						echo $this->Form->file('File');
                        echo $this->Form->submit('Upload',array('class'=>'tiny radius button bg-blue'));

				?>
				
			  </div>
              <div class="large-12 columns">
                    <?php if($invalidStudentNumberList['successCount']){ ?>
                            <div class="success-box success-message'">
                                <?php 
                                    echo $invalidStudentNumberList['successCount'].' students grade has successfully imported';
                                ?>
                            </div>

                    <?php 
                        unset($invalidStudentNumberList['successCount']);
                    } ?>
        <?php
        if(isset($invalidStudentNumberList['StudentList'])){

              
                echo "<ul style='color:red'>";
                foreach($invalidStudentNumberList['StudentList'] as $k=>$v){
                    echo "<li>".$v." </li>";
                }
            echo "</ul>";
           
        }

        ?>

              </div>
	   </div> <!-- end of row -->
   </div> <!-- end of box-body -->
</div><!-- end of box -->

<?php    
echo $this->Form->end();

?>

