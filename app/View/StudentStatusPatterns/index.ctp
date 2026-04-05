<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Student Status Patterns'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div style="margin-top: -30px;"><hr></div>
				<div class="studentStatusPatterns index">
					<div style="overflow-x:auto;">
						<table cellpadding="0" cellspacing="0" class="tablle">
							<thead>
								<tr>
									<th class="vcenter">#</th>
									<th class="vcenter"><?= $this->Paginator->sort('program_id');?></th>
									<th class="center"><?= $this->Paginator->sort('program_type_id');?></th>
									<th class="center"><?= $this->Paginator->sort('acadamic_year');?></th>
									<th class="center"><?= $this->Paginator->sort('application_date');?></th>
									<th class="center"><?= $this->Paginator->sort('pattern');?></th>
									<th class="center"><?= $this->Paginator->sort('created');?></th>
									<th class="center"><?= $this->Paginator->sort('modified');?></th>
									<th class="center"><?= __('Actions');?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($studentStatusPatterns)) {
									foreach ($studentStatusPatterns as $studentStatusPattern) { ?>
										<tr>
											<td class="center"><?= $studentStatusPattern['StudentStatusPattern']['id']; ?></td>
											<td class="vcenter"><?= $this->Html->link($studentStatusPattern['Program']['name'], array('controller' => 'programs', 'action' => 'view', $studentStatusPattern['Program']['id'])); ?></td>
											<td class="center"><?= $this->Html->link($studentStatusPattern['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $studentStatusPattern['ProgramType']['id'])); ?></td>
											<td class="center"><?= $studentStatusPattern['StudentStatusPattern']['acadamic_year']; ?></td>
											<td class="center"><?= $this->Time->format("M j, Y", $studentStatusPattern['StudentStatusPattern']['application_date'], NULL, NULL); ?></td>
											<td class="center"><?= $studentStatusPattern['StudentStatusPattern']['pattern']; ?></td>
											<td class="center"><?= $this->Time->format("M j, Y g:i A", $studentStatusPattern['StudentStatusPattern']['created'], NULL, NULL); ?></td>
											<td class="center"><?= $this->Time->format("M j, Y g:i A", $studentStatusPattern['StudentStatusPattern']['modified'], NULL, NULL); ?></td>
											<td class="center">
												<?php //echo $this->Html->link(__(''), array('action' => 'view', $studentStatusPattern['StudentStatusPattern']['id']), array('class' => 'fontello-eye', 'title' => 'View')); ?> <!-- &nbsp; -->
												<?= $this->Html->link(__(''), array('action' => 'edit', $studentStatusPattern['StudentStatusPattern']['id']), array('class' => 'fontello-pencil', 'title' => 'Edit')); ?> &nbsp;
                                                <?= $this->Html->link(__(''), array('action' => 'delete', $studentStatusPattern['StudentStatusPattern']['id']), array('class' => 'fontello-trash', 'title' => 'Delete'), sprintf(__('Are you sure you want to delete status pattern defined for  %s - %s?'), $studentStatusPattern['Program']['name'], $studentStatusPattern['ProgramType']['name'])); ?>
											</td>
										</tr>
										<?php 
									} 
								} ?>
							</tbody>
						</table>
					</div>
					<br>

					<hr>
					<div class="row">
						<div class="large-5 columns">
							<?= $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total'))); ?>
						</div>
						<div class="large-7 columns">
							<div class="pagination-centered">
								<ul class="pagination">
									<?= $this->Paginator->prev('<< ' . __(''), array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?> <?= $this->Paginator->numbers(array('separator' => '', 'tag' => 'li')); ?> <?= $this->Paginator->next(__('') . ' >>', array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
	  		</div>
		</div>
    </div>
</div>
