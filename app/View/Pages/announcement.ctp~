<?php 
  echo $this->Form->Create('Page');
?>
<div class="large-12 columns">
	 <h2 class="box-title">
	<?php echo __('Announcements');?>
	  </h2>
	</div>
	<?php if(isset($announcements) && !empty($announcements)) { 
	foreach($announcements as $k=>$v){
	?>
	<article class="reading-nest">
        <h3><a href="#"><?php echo $v['Announcement']['headline']; ?></a></h3>
        <h6>Written by <a href="#"><?php echo $v['User']['first_name'].' '.$v['User']['last_name']; ?></a> on 
        <?php echo $this->Format->short_date($v['Announcement']['created']); ?> </h6>
		<p><?php echo $v['Announcement']['story']; ?></p>
    </article>
	<hr/>
	<?php 
		}
	} 
	?>
</div>

