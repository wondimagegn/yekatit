
<?php 
/*
echo $this->Form->create('Student',array('type'=>'file','novalidate' => true,
'enctype'=>"multipart/form-data"));*/
echo $this->Form->create('Student', array('controller' => 'students', 'action' => 'mass_import_profile_picture', 'type' => 'file'));

?>


<div class="box">
     <div class="box-body pad-forty">
       <div class="row">
		   	 <div class="large-12 columns">
		   	 	   <h4><?php echo __('Upload Mass Profile Pictures'); ?></h4>		
		   	 </div>
			  <div class="large-6 columns">
         

				   <label><strong>Student List : </strong>

				   <?php    
						echo $this->Form->file('File',array('label'=>'Excel','name'=>'data[Student][xls]'));

				?>
				</label><br/>


                 
	  <label><strong>Upload File : </strong>
<input type="file"  name="data[Student][File][]" id="multiplefilesfilter" multiple="multiple" accept="image/*"/></label><br/>
     <?php 
    echo $this->Form->submit('Upload',array('class'=>'tiny radius button bg-blue'));

?>
			  </div> <!-- end of columns 6 -->
			  <div class="large-6 columns">
                       
                        <div class="your-account">
                            <div class="row">
                                <div class="medium-3 columns">
                                    <!-- <div class="circle-progress"></div> -->
                                    <div class="circlestat" data-dimension="90" 
data-text="<?php echo number_format((($profilePictureUploaded/$totalStudentCount)*100),2,'.','').''.'%'; ?>" data-width="8" data-fontsize="16" data-percent="<?php  echo ((($profilePictureUploaded*100)/$totalStudentCount));?>" data-fgcolor="#222" data-border="5" data-bgcolor="#D5DAE6" data-fill="#FFF"></div>
                                </div>
                                 <div class="medium-9 columns ">
                                    <div style="margin:0 10px;padding:0 0 0 20px" class="summary-border-left">
                                        <h4>Profile picture upload isn't complete!</h4>

                                    </div>
                                </div>
                             </div>
                        </div>


			  </div>
	   </div> <!-- end of row --->
   </div> <!-- end of box-body -->
</div><!-- end of box -->

<?php    
echo $this->Form->end();

?>
<script>

/**
 * Created by remi on 17/01/15.
 */
(function () {

    /**
     * A simple function to display file informations
     */
    function showFileInfo(file){
        console.log("name : " + file.name);
        console.log("size : " + file.size);
        console.log("type : " + file.type);
        console.log("date : " + file.lastModified);
    }


    var fileInput3 = document.querySelector('#multiplefilesfilter');
    fileInput3.addEventListener('change', function () {
        var files = this.files;
        for(var i=0; i<files.length; i++){
            console.group('File '+i);
            showFileInfo(files[i]);
            console.groupEnd();
        }
    }, false);

}());
</script>

