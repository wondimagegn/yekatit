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
                        <ul style="margin-bottom:20px;">
                            <li><strong><?php echo __('Database Backup Path'); ?>:</strong> <?php echo h($databasePath); ?></li>
                            <li><strong><?php echo __('Media Path'); ?>:</strong> <?php echo h($mediaPath); ?></li>
                            <li><strong><?php echo __('Media Full Backup Path'); ?>:</strong> <?php echo h($mediaFullPath); ?></li>
                            <li><strong><?php echo __('Media Incremental Backup Path'); ?>:</strong> <?php echo h($mediaIncrementalPath); ?></li>
                            <li><em><?php echo __('Backups are created by CakePHP shell / cron, not from the web UI.'); ?></em></li>
                        </ul>

					</blockquote>
                    <div class="backups index">


                        <h3><?php echo __('Database Backups'); ?></h3>
                        <?php echo $this->element('backups_table', array('items' => $databaseBackups, 'type' => 'database')); ?>

                        <h3 style="margin-top:30px;"><?php echo __('Media Full Backups'); ?></h3>
                        <?php echo $this->element('backups_table', array('items' => $mediaFullBackups, 'type' => 'media_full')); ?>

                        <h3 style="margin-top:30px;"><?php echo __('Media Incremental Backups'); ?></h3>
                        <?php echo $this->element('backups_table', array('items' => $mediaIncrementalBackups, 'type' => 'media_incremental')); ?>



                    </div>


                </div>
			</div>
		</div>
	</div>
</div>