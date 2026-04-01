<div class="helps index">
	<div class="smallheading"><?php __('SMIS Users Manuals');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th style="width:5%">S.N<u>o</u></th>
			<th style="width:38%"><?php echo $this->Paginator->sort('Title of the Manual', 'title');?></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('Manual Release Date', 'document_release_date');?></th>
			<th style="width:10%"><?php echo $this->Paginator->sort('version');?></th>
			<th style="width:25%"><?php echo $this->Paginator->sort('Manual', 'Document');?></th>
			<th style="width:5%; text-align:center" class="actions"><?php __('Actions');?></th>
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
                //echo 'PDF file uploaded on: '.$this->Format->humanize_date($cuv['created']);
                echo '<a href='.$this->Media->url($cuv['dirname'].DS.$cuv['basename'],true).' target=_blank>View User Manual</a>';
        } 
        ?>
		&nbsp;</td>
		
		<td class="actions">
			
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $help['Help']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $help['Help']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $help['Help']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
