<?php 
?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title"> <?php echo __('SMIS Users Manuals');?></h2>
     </div>
     <div class="box-body">
	<div class="dataTables_wrapper">
	<table class="display" style="width:100%" cellpadding="0" cellspacing="0">
	<tr>
			<th style="width:5%">S.N<u>o</u></th>
			<th style="width:38%"><?php echo $this->Paginator->sort('title','Title of the Manual');?></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('document_release_date','Manual Release Date');?></th>
			<th style="width:10%"><?php echo $this->Paginator->sort('Version','version');?></th>
			<th style="width:25%"><?php echo $this->Paginator->sort('Document','Manual');?></th>
			<th style="width:5%; text-align:center" class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php

	$i = 0;
	$start = $this->Paginator->counter('%start%');

	foreach ($helps as $help):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $help['Help']['title']; ?>&nbsp;</td>
		<td><?php echo $this->Format->short_date($help['Help']['document_release_date']); ?>&nbsp;</td>
		<td><?php echo $help['Help']['version']; ?>&nbsp;</td>
		<td>
		<?php 
		
		 foreach ($help['Attachment'] as $cuk=>$cuv) {   
                
                echo '<a href='.$this->Media->url($cuv['dirname'].DS.$cuv['basename'],true).' target=_blank>View User Manual</a>';
        } 
        ?>
		&nbsp;</td>
		
		<td class="actions">
			
			<?php 
            if($role_id==ROLE_SYSADMIN){
			echo $this->Html->link(__('Edit'), array('action' => 'edit', $help['Help']['id']));  echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $help['Help']['id']), array(), __('Are you sure you want to delete # %s?', $help['Help']['title'])); 
			}
			?>


		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="pagination-centered">
	<ul class="pagination">
	<?php
		echo $this->Paginator->prev('<< ' . __(''), array('tag'=>'li'), null, array('class' => 'arrow unavailable '));
		echo $this->Paginator->numbers(array('separator' => '','tag'=>'li'));
		echo $this->Paginator->next(__('') . ' >>', array('tag'=>'li'), null, array('class' => 'arrow  unavailable'));
	?>
	</ul>
	</div>

  </div>
</div>
</div>
