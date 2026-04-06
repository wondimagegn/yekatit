<div class="courseSplitSections view">
<h2><?php  __('Course Split Section');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseSplitSection['CourseSplitSection']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section Split For Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseSplitSection['SectionSplitForPublishedCourse']['id'], array('controller' => 'section_split_for_published_courses', 'action' => 'view', $courseSplitSection['SectionSplitForPublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseSplitSection['CourseSplitSection']['section_name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Split Section', true), array('action' => 'edit', $courseSplitSection['CourseSplitSection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Course Split Section', true), array('action' => 'delete', $courseSplitSection['CourseSplitSection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseSplitSection['CourseSplitSection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Section Split For Published Courses', true), array('controller' => 'section_split_for_published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section Split For Published Course', true), array('controller' => 'section_split_for_published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
