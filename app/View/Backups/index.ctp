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

                        <div style="margin-bottom:20px;">
                            <p><strong><?php echo __('Database Backup Path'); ?>:</strong> <?php echo h($databasePath); ?></p>
                            <p><strong><?php echo __('Media Path'); ?>:</strong> <?php echo h($mediaPath); ?></p>
                            <p><strong><?php echo __('Media Full Backup Path'); ?>:</strong> <?php echo h($mediaFullPath); ?></p>
                            <p><strong><?php echo __('Media Incremental Backup Path'); ?>:</strong> <?php echo h($mediaIncrementalPath); ?></p>
                        </div>

                        <div style="margin-bottom:24px;">
                            <?php
                            echo $this->Form->create('DatabaseBackup', array(
                                    'url' => array('controller' => 'backups', 'action' => 'create_database_backup'),
                                    'type' => 'post',
                                    'style' => 'display:inline-block;margin-right:10px;'
                            ));
                            echo $this->Form->submit(__('Create Database Backup'), array('div' => false, 'class' => 'btn btn-primary'));
                            echo $this->Form->end();

                            echo $this->Form->create('MediaFullBackup', array(
                                    'url' => array('controller' => 'backups', 'action' => 'create_media_full_backup'),
                                    'type' => 'post',
                                    'style' => 'display:inline-block;margin-right:10px;'
                            ));
                            echo $this->Form->submit(__('Create Media Full Backup'), array('div' => false, 'class' => 'btn btn-success'));
                            echo $this->Form->end();

                            echo $this->Form->create('MediaIncrementalBackup', array(
                                    'url' => array('controller' => 'backups', 'action' => 'create_media_incremental_backup'),
                                    'type' => 'post',
                                    'style' => 'display:inline-block;'
                            ));
                            echo $this->Form->submit(__('Create Media Incremental Backup'), array('div' => false, 'class' => 'btn btn-warning'));
                            echo $this->Form->end();
                            ?>
                        </div>

                        <h3><?php echo __('Database Backups'); ?></h3>
                        <?php echo $this->element('backups_table', array(
                                'items' => $databaseBackups,
                                'type' => 'database'
                        )); ?>

                        <h3 style="margin-top:30px;"><?php echo __('Media Full Backups'); ?></h3>
                        <?php echo $this->element('backups_table', array(
                                'items' => $mediaFullBackups,
                                'type' => 'media_full'
                        )); ?>

                        <h3 style="margin-top:30px;"><?php echo __('Media Incremental Backups'); ?></h3>
                        <?php echo $this->element('backups_table', array(
                                'items' => $mediaIncrementalBackups,
                                'type' => 'media_incremental'
                        )); ?>
                    </div>


                </div>
			</div>
		</div>
	</div>
</div>