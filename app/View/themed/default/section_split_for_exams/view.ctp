<div class="sectionSplitForExams view">
<h2><?php  __('Section Split For Exam');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($sectionSplitForExam['Section']['name'], array('controller' => 'sections', 'action' => 'view', $sectionSplitForExam['Section']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($sectionSplitForExam['PublishedCourse']['Course']['course_code_title'], array('controller' => 'published_courses', 'action' => 'view', $sectionSplitForExam['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php __('Related Exam Split Sections');?></h3>
	<?php if (!empty($sectionSplitForExam['ExamSplitSection'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('S.N<u>o</u>'); ?></th>
		<th><?php __('Section Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$count = 1;
		foreach ($sectionSplitForExam['ExamSplitSection'] as $examSplitSection):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $count++;?></td>
			<td><?php echo $examSplitSection['section_name'];?></td>
			<td class="actions">
			<!---	<?php echo $this->Html->link(__('View', true), array('controller' => 'exam_split_sections', 'action' => 'view', $examSplitSection['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'exam_split_sections', 'action' => 'edit', $examSplitSection['id'])); ?> --->
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'exam_split_sections', 'action' => 'delete', $examSplitSection['id']), null, sprintf(__('Are you sure you want to delete?', true), $examSplitSection['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
