<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-database-1"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Download Database Backup'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div style="margin-top: -30px;">
					<hr>
					<blockquote>
						<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
						<p style="text-align:justify;">
							<span class="fs16">After download, <u class="text-red">please don't forget to store the backup to external backup device outside of the server room.</u></span>
						</p>
					</blockquote>

                    <div class="backups index">
                        <h2><?php echo __('Backups'); ?></h2>

                        <div style="margin-bottom: 20px;">
                            <p><strong><?php echo __('Backup Path'); ?>:</strong> <?php echo h($backupPath); ?></p>
                            <p><strong><?php echo __('Media Path'); ?>:</strong> <?php echo h($mediaPath); ?></p>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <?php

                            echo $this->Form->create('Backup', array(
                                    'url' => array('action' => 'create'),
                                    'style' => 'display:inline-block;margin-right:15px;'
                            ));


                            echo $this->Form->button(__('Create Backup'), array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary'
                            ));
                            echo $this->Form->end();

                            echo $this->Form->create('Backup', array(
                                    'url' => array('action' => 'prune'),
                                    'style' => 'display:inline-block;'
                            ));
                            echo $this->Form->input('prune_days', array(
                                    'label' => __('Delete backups older than (days)'),
                                    'type' => 'number',
                                    'value' => 30,
                                    'min' => 1,
                                    'div' => false,
                                    'style' => 'width:100px;display:inline-block;margin-right:10px;'
                            ));
                            echo $this->Form->button(__('Prune'), array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-warning',
                                    'confirm' => __('Delete old backup files?')
                            ));
                            echo $this->Form->end();
                            ?>
                        </div>

                        <?php if (empty($backups)): ?>
                            <p><?php echo __('No backups found.'); ?></p>
                        <?php else: ?>
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><?php echo __('Filename'); ?></th>
                                    <th><?php echo __('Size'); ?></th>
                                    <th><?php echo __('Modified'); ?></th>
                                    <th><?php echo __('Status'); ?></th>
                                    <th><?php echo __('Created By'); ?></th>
                                    <th><?php echo __('Created At'); ?></th>
                                    <th><?php echo __('Restored By'); ?></th>
                                    <th><?php echo __('Restored At'); ?></th>
                                    <th><?php echo __('Last Error'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($backups as $item): ?>
                                    <?php
                                    $file = $item['file'];
                                    $record = $item['record'];

                                    $status = !empty($record['Backup']['status']) ? $record['Backup']['status'] : __('untracked');

                                    $createdBy = '-';
                                    if (!empty($record['CreatedBy']['id'])) {
                                        $createdNameParts = array_filter(array(
                                                !empty($record['CreatedBy']['first_name']) ? $record['CreatedBy']['first_name'] : '',
                                                !empty($record['CreatedBy']['middle_name']) ? $record['CreatedBy']['middle_name'] : '',
                                                !empty($record['CreatedBy']['last_name']) ? $record['CreatedBy']['last_name'] : '',
                                        ));
                                        $createdBy = !empty($createdNameParts)
                                                ? implode(' ', $createdNameParts)
                                                : (!empty($record['CreatedBy']['username']) ? $record['CreatedBy']['username'] : $record['CreatedBy']['id']);
                                    }

                                    $restoredBy = '-';
                                    if (!empty($record['RestoredBy']['id'])) {
                                        $restoredNameParts = array_filter(array(
                                                !empty($record['RestoredBy']['first_name']) ? $record['RestoredBy']['first_name'] : '',
                                                !empty($record['RestoredBy']['middle_name']) ? $record['RestoredBy']['middle_name'] : '',
                                                !empty($record['RestoredBy']['last_name']) ? $record['RestoredBy']['last_name'] : '',
                                        ));
                                        $restoredBy = !empty($restoredNameParts)
                                                ? implode(' ', $restoredNameParts)
                                                : (!empty($record['RestoredBy']['username']) ? $record['RestoredBy']['username'] : $record['RestoredBy']['id']);
                                    }

                                    $createdAt = !empty($record['Backup']['created_at']) ? $record['Backup']['created_at'] : '-';
                                    $restoredAt = !empty($record['Backup']['restored_at']) ? $record['Backup']['restored_at'] : '-';
                                    $errorMessage = !empty($record['Backup']['error_message']) ? $record['Backup']['error_message'] : '-';
                                    ?>
                                    <tr>
                                        <td><?php echo h($file['name']); ?></td>
                                        <td><?php echo number_format($file['size'] / 1024, 2); ?> KB</td>
                                        <td><?php echo h($file['modified']); ?></td>
                                        <td><?php echo h($status); ?></td>
                                        <td><?php echo h($createdBy); ?></td>
                                        <td><?php echo h($createdAt); ?></td>
                                        <td><?php echo h($restoredBy); ?></td>
                                        <td><?php echo h($restoredAt); ?></td>
                                        <td style="max-width:250px;word-break:break-word;"><?php echo h($errorMessage); ?></td>
                                        <td class="actions">
                                            <?php
                                            echo $this->Html->link(
                                                    __('Download'),
                                                    array('action' => 'download', $file['name']),
                                                    array('class' => 'btn btn-sm btn-default')
                                            );

                                            echo ' ';

                                            /*
                                            echo $this->Form->postLink(
                                                    __('Restore'),
                                                    array('action' => 'restore', $file['name']),
                                                    array('class' => 'btn btn-sm btn-warning'),
                                                    __('This will overwrite the database and media folder. Continue?')
                                            );
                                            */

                                            echo ' ';

                                            echo $this->Form->postLink(
                                                    __('Delete'),
                                                    array('action' => 'delete', $file['name']),
                                                    array('class' => 'btn btn-sm btn-danger'),
                                                    __('Delete this backup file?')
                                            );
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>

				</div>
			</div>
		</div>
	</div>
</div>