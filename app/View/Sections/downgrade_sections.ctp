<?php ?>
<div class="box">
  <div class="box-body">
	<div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Downgrade year level of section');?>
		      </h2>
		</div>
		<div class="large-12 columns">
                <?php
	/*
    $this->Html->scriptBlock("
        jQuery(function($){
            $('downgradeSection').submit(function(event){
              $('downgradeSection').di
            });
        });
    ",array('inline'=>false));
	*/

echo $this->Form->create('Section');   


?>
 <p class='fs16'><u><span style="color:red">Beware:</span> 
    Downgrade a given section if only necessary.</u>
    <ul>
        <li>You are advice to use downgrade only if you upgrade section by mistake.</li>
        <li>To downgrade a given section, the section must not ever have 
    published course.</li>
        <li>Here you get only potentially downgrade able section as options</li>
    </ul>
 
</p>

<div onclick="toggleViewFullId('ListDowngradableSection')"><?php 
    if (!empty($sections)) {
        echo $this->Html->image('plus2.gif', array('id' => 'ListDowngradableSectionImg')); 
        ?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListDowngradableSectionTxt">Display Filter</span><?php
        }
    else {
        echo $this->Html->image('minus2.gif', array('id' => 'ListDowngradableSectionImg')); 
        ?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListDowngradableSectionTxt">Hide Filter</span><?php
        }
?>
</div>
<div id="ListDowngradableSection" style="display:<?php echo (!empty($formateddowngradableSections) ? 'none' : 'display'); ?>">
<table cellpadding="0" cellspacing="0">
	<?php 
       
        echo '<tr><td>'. $this->Form->input('Section.college_id',array('id'=>'ajax_college_id','label'=>false,
             'type'=>'select','id'=>'ajax_college_id','onchange'=>'getDepartments()','div'=>false,'style'=>'width:60%')).'</td>'; 
        echo '<td>'. $this->Form->input('Section.department_id',array('id'=>'ajax_department_id','label'=>false,
             'type'=>'select','id'=>'ajax_department_id',
             'onchange'=>'getYearLevel()','div'=>false,'style'=>'width:60%')).'</td></tr>';  
        echo '<tr><td>'. $this->Form->input('Section.program_id',array('empty'=>"--Select Program--")).'</td>'; 
        echo '<td>'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--")).'</td></tr>';  
         echo '<tr><td>'. $this->Form->input('Section.academicyear',array('type'=>'select', 'options'=>$acyear_array_data,'empty'=>'--Select Academic Year--')).'</td>';   
        echo '<td>'. $this->Form->input('Section.year_level_id',array('empty'=>'All','id'=>'ajax_year_level_id')).'</td></tr>'; 
        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>'; 

	?> 
</table>
</div>
<div>
<?php

if(!empty($formateddowngradableSections)){

	echo '<table>';
	echo '<tr>';
		debug($formateddowngradableSections);	
		foreach($formateddowngradableSections as $k=>$v) {
echo '<td>'.$this->Form->input('Section.Downgradable_Selected.'.$k,array('class'=>'downgradableSelectedSection','type'=>'checkbox',
'value'=>$k,'label'=>$v)).'</td>';
}

'</tr>';


	echo '<tr><td>'.$this->Form->Submit('Downgrade',array('name'=>'downgrade','div'=>false,'class'=>'tiny radius button bg-blue',
	'onClick'=>'return confirm("Are you sure you want to downgrade selected section?")','id'=>'downgradeSection')).'</td></tr>';


	echo '</table>';
} else if(empty($formateddowngradableSections) && !($isbeforesearch)) { 
	echo "<div class='info-box info-message'><span></span> There is no section to upgradre in the search criteria </div>";
} 

$this->Form->end(); 
?>
		</div>
	  </div>
   </div>
</div>
</div>

<script type="text/javascript">
 function toggleView(obj) {
    if($('#c'+obj.id).css("display") == 'none')
        $('#i'+obj.id).attr("src", '/img/minus2.gif');
    else
        $('#i'+obj.id).attr("src", '/img/plus2.gif');
    $('#c'+obj.id).toggle("slow");
}

function toggleViewFullId(id) {
    if($('#'+id).css("display") == 'none') {
        $('#'+id+'Img').attr("src", '/img/minus2.gif');
        $('#'+id+'Txt').empty();
        $('#'+id+'Txt').append('Hide Filter');
        }
    else {
        $('#'+id+'Img').attr("src", '/img/plus2.gif');
        $('#'+id+'Txt').empty();
        $('#'+id+'Txt').append('Display Filter');
        }
    $('#'+id).toggle("slow");
}

    function getDepartments() {
                //serialize form data
                var col = $("#ajax_college_id").val();
                $("#ajax_department_id").attr('disabled', true);
                $("#ajax_department_id").empty().html('<img src="/img/busy.gif" class="displayed" >');
                $("#ajax_year_level_id").empty();
                //get form action
                var formUrl = '/course_schedules/get_departments/'+col;
                $.ajax({
                    type: 'get',
                    url: formUrl,
                    data: col,
                    success: function(data,textStatus,xhr){
                            $("#ajax_department_id").attr('disabled', false);
                            $("#ajax_department_id").empty();
                            $("#ajax_department_id").append(data);
                    },
                    error: function(xhr,textStatus,error){
                            alert(textStatus);
                    }
                });
                return false;
     }

     //Get year level
    function getYearLevel() {
                //serialize form data
                var dept = $("#ajax_department_id").val();
                $("#ajax_year_level_id").attr('disabled', true);
                $("#ajax_year_level_id").empty().
                html('<img src="/img/busy.gif" class="displayed" >');
                var formUrl = '/dormitory_assignments/get_year_levels/'+dept;
                $.ajax({
                    type: 'get',
                    url: formUrl,
                    data: dept,
                    success: function(data,textStatus,xhr){
                        $("#ajax_year_level_id").attr('disabled', false);
                        $("#ajax_year_level_id").empty();
                        
                        $("#ajax_year_level_id").append(data);
                    },
                    error: function(xhr,textStatus,error){
                            alert(textStatus);
                    }
                });
                return false;
    }
     

</script>

