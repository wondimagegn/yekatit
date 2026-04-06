<div class="box">
    <div class="box-body">
    	<div class="row">
			<div class="large-12 columns">
				<div class="programTypes index">
					<h2><?= __('Program Types'); ?></h2>
					<table cellpadding="0" cellspacing="0" class="table">
						<thead>
							<tr>
								<th><?= $this->Paginator->sort('id'); ?></th>
								<th><?= $this->Paginator->sort('name'); ?></th>
								<th><?= $this->Paginator->sort('description'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($programTypes)) {
								foreach ($programTypes as $programType) { ?>
									<tr>
										<td><?= $programType['ProgramType']['id']; ?></td>
										<td><?= $programType['ProgramType']['name']; ?></td>
										<td><?= $programType['ProgramType']['description']; ?></td>
									</tr>
									<?php 
								}  
							} ?>
						</tbody>
					</table>
					<br>

					<p><?= $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></p>

					<div class="paging">
						<?= $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?> | 	<?= $this->Paginator->numbers();?> | <?= $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
